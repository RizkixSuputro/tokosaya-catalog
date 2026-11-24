<?php

namespace App\Services;

use App\Models\Pesanan;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;           // dipakai mulai Pertemuan 10
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class Midtrans
{
    /** Lama waktu pembeli boleh membayar, dalam jam */
    const BATAS_JAM = 24;

    /**
     * Meminta halaman pembayaran kepada Midtrans.
     * Mengembalikan alamat yang harus dituju pembeli.
     *
     * @throws RuntimeException bila halaman pembayaran tidak dapat dibuat
     */
    public static function mintaHalamanBayar(Pesanan $pesanan): string
    {
        // ---------- 1. Pesanan yang tidak boleh dibayar lagi ----------
        if (! $pesanan->bisaDibayar()) {
            throw new RuntimeException("Pesanan {$pesanan->kode_pesanan} sudah tidak dapat dibayar.");
        }

        // ---------- 2. Halaman yang masih berlaku dipakai lagi ----------
        // Pembeli yang sudah memilih VA perlu melihat nomornya lagi,
        // dan Midtrans menolak halaman baru untuk order_id itu — lihat H.4
        if (
            $pesanan->status_bayar === 'pending'
            && $pesanan->midtrans_redirect_url
            && $pesanan->batas_bayar?->isFuture()
        ) {
            return $pesanan->midtrans_redirect_url;
        }

        // ---------- 3. Menentukan order_id ----------
        // Pertama kali sama dengan kode_pesanan. Sesudahnya order_id lama
        // sudah terpakai di Midtrans, jadi diberi akhiran waktu
        $orderId = $pesanan->midtrans_order_id
            ? $pesanan->kode_pesanan . '-' . now()->format('ymdHis')
            : $pesanan->kode_pesanan;

        // ---------- 4. Menyusun rincian barang ----------
        $pesanan->loadMissing('detail');

        $rincian = [];

        foreach ($pesanan->detail as $baris) {
            $rincian[] = [
                'id'       => (string) ($baris->produk_id ?? 'X'),
                'name'     => Str::limit($baris->nama_produk, 47, '...'),
                'price'    => (int) round($baris->harga),
                'quantity' => (int) $baris->jumlah,
            ];
        }

        // Ongkos kirim ikut sebagai satu baris agar jumlahnya pas.
        // Ongkos kirim dari RajaOngkir (Pertemuan 11).
        if ((int) round($pesanan->ongkir) > 0) {
            $rincian[] = [
                'id'       => 'ONGKIR',
                'name'     => Str::limit("Ongkir {$pesanan->kurir} {$pesanan->layanan_kurir}", 47, '...'),
                'price'    => (int) round($pesanan->ongkir),
                'quantity' => 1,
            ];
        }

        // ---------- 5. Memeriksa jumlah sebelum dikirim ----------
        $total         = (int) round($pesanan->total);
        $jumlahRincian = collect($rincian)->sum(fn($r) => $r['price'] * $r['quantity']);

        if ($jumlahRincian !== $total) {
            throw new RuntimeException(
                "Jumlah rincian ({$jumlahRincian}) tidak sama dengan total pesanan ({$total})."
            );
        }

        // ---------- 6. Muatan JSON ----------
        $mulai = now();

        $muatan = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $total,
            ],
            'item_details' => $rincian,
            'customer_details' => [
                'first_name' => $pesanan->nama_pemesan,
                'email'      => $pesanan->email,
                'phone'      => $pesanan->telepon,
                'shipping_address' => [
                    'first_name'   => $pesanan->nama_pemesan,
                    'phone'        => $pesanan->telepon,
                    'address'      => $pesanan->alamat,
                    'city'         => $pesanan->kota,
                    'postal_code'  => $pesanan->kode_pos,
                    'country_code' => 'IDN',
                ],
            ],
            'callbacks' => [
                'finish' => route('checkout.selesai', $pesanan->kode_pesanan),
            ],
            'expiry' => [
                'start_time' => $mulai->format('Y-m-d H:i:s O'),
                'unit'       => 'hours',
                'duration'   => self::BATAS_JAM,
            ],
        ];

        // ---------- 7. Mengirim ----------
        try {
            $jawaban = Http::withBasicAuth(config('midtrans.server_key'), '')
                ->acceptJson()
                ->timeout(15)
                ->post(config('midtrans.snap_url'), $muatan);
        } catch (ConnectionException $e) {
            // Internet putus, nama domain tidak ditemukan,
            // atau Midtrans tidak menjawab dalam 15 detik
            Log::error('Midtrans tidak dapat dihubungi', [
                'kode_pesanan' => $pesanan->kode_pesanan,
                'galat'        => $e->getMessage(),
            ]);

            throw new RuntimeException('Midtrans tidak dapat dihubungi.', 0, $e);
        }

        if ($jawaban->failed() || ! $jawaban->json('redirect_url')) {
            Log::error('Midtrans menolak permintaan', [
                'kode_pesanan' => $pesanan->kode_pesanan,
                'status'       => $jawaban->status(),
                'jawaban'      => $jawaban->json(),
            ]);

            throw new RuntimeException(
                $jawaban->json('error_messages.0') ?? "Midtrans menjawab {$jawaban->status()}."
            );
        }

        // ---------- 8. Menyimpan jejaknya ----------
        $pesanan->update([
            'midtrans_order_id'     => $orderId,
            'midtrans_redirect_url' => $jawaban->json('redirect_url'),
            'batas_bayar'           => $mulai->copy()->addHours(self::BATAS_JAM),
            'status_bayar'          => 'pending',
        ]);

        return $pesanan->midtrans_redirect_url;
    }

    /**
     * Menerjemahkan status Midtrans menjadi status_bayar kita,
     * lalu menerapkannya. Aman dijalankan berulang kali dan bersamaan.
     *
     * Dipakai oleh webhook maupun pemeriksaan status manual (G.6).
     */
    public static function terapkan(Pesanan $pesanan, array $muatan): string
    {
        return DB::transaction(function () use ($pesanan, $muatan) {

            // ---------- 1. Kunci baris pesanan ----------
            // Dua notifikasi yang datang bersamaan harus antre,
            // bukan membaca keadaan lama yang sama
            $pesanan = Pesanan::lockForUpdate()->findOrFail($pesanan->id);
            $lama    = $pesanan->status_bayar;

            // ---------- 2. Menerjemahkan ----------
            $status = $muatan['transaction_status'] ?? '';
            $fraud  = $muatan['fraud_status'] ?? 'accept';

            $baru = match (true) {
                $status === 'settlement'                        => 'lunas',
                $status === 'capture' && $fraud === 'accept'     => 'lunas',
                $status === 'capture' && $fraud === 'challenge'  => 'pending',
                $status === 'capture' && $fraud === 'deny'       => 'gagal',
                $status === 'pending'                           => 'pending',
                $status === 'expire'                            => 'kedaluwarsa',
                in_array($status, ['deny', 'cancel', 'failure'], true) => 'gagal',

                // authorize, refund, chargeback: tidak kita tangani di
                // mata kuliah ini, status dibiarkan apa adanya
                default => $lama,
            };

            // ---------- 3. Keadaan tidak boleh mundur ----------
            // Lunas hanya boleh berubah karena pembalikan (settlement → deny)
            if ($lama === 'lunas' && $status !== 'deny') {
                return 'lunas';
            }

            // Gagal dan kedaluwarsa tidak boleh kembali menjadi pending
            if (in_array($lama, ['gagal', 'kedaluwarsa'], true) && $baru === 'pending') {
                return $lama;
            }

            // ---------- 4. Menerapkan ----------
            $pesanan->status_bayar = $baru;

            if ($baru === 'lunas') {
                $pesanan->metode_bayar = $muatan['payment_type'] ?? null;
                $pesanan->dibayar_pada = $pesanan->dibayar_pada ?? now();

                if ($pesanan->stok_dikembalikan) {
                    // Pembeli membayar halaman lama setelah pesanannya dibatalkan.
                    // Uangnya masuk, tetapi stoknya sudah dilepas — perlu manusia
                    Log::warning('Pesanan lunas setelah stoknya dikembalikan', [
                        'kode_pesanan' => $pesanan->kode_pesanan,
                    ]);
                }
            }

            if (in_array($baru, ['gagal', 'kedaluwarsa'], true)) {
                $pesanan->kembalikanStok();

                // Pesanan yang belum diproses ikut dibatalkan
                if ($pesanan->status === 'baru') {
                    $pesanan->status = 'batal';
                }

                if ($lama === 'lunas') {
                    $pesanan->dibayar_pada = null;

                    Log::warning('Pembayaran dibalik oleh Midtrans', [
                        'kode_pesanan' => $pesanan->kode_pesanan,
                    ]);
                }
            }

            $pesanan->save();

            return $baru;
        });
    }

    /**
     * Membaca status terkini sebuah transaksi dari Midtrans,
     * lalu menerapkannya lewat terapkan().
     */
    public static function periksaStatus(Pesanan $pesanan): string
    {
        if (! $pesanan->midtrans_order_id) {
            return $pesanan->status_bayar;
        }

        try {
            $jawaban = Http::withBasicAuth(config('midtrans.server_key'), '')
                ->acceptJson()
                ->timeout(15)
                ->get(config('midtrans.api_url')
                    . '/v2/' . $pesanan->midtrans_order_id . '/status');
        } catch (ConnectionException $e) {
            Log::warning('Midtrans tidak dapat dihubungi saat memeriksa status', [
                'order_id' => $pesanan->midtrans_order_id,
                'galat'    => $e->getMessage(),
            ]);

            return $pesanan->status_bayar;
        }

        // 404 adalah jawaban wajar: pembeli belum memilih metode,
        // jadi di sisi Midtrans memang belum ada transaksi
        if ($jawaban->failed() || $jawaban->json('status_code') === '404') {
            return $pesanan->status_bayar;
        }

        return self::terapkan($pesanan, $jawaban->json());
    }
}
