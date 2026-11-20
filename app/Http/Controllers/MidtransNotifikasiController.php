<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Services\Midtrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransNotifikasiController extends Controller
{
    public function __invoke(Request $request)
    {
        $muatan = $request->all();

        // ---------- 1. Muatan harus lengkap ----------
        foreach (['order_id', 'status_code', 'gross_amount', 'signature_key'] as $wajib) {
            if (! isset($muatan[$wajib])) {
                Log::warning('Notifikasi Midtrans tidak lengkap', $muatan);

                return response()->json(['pesan' => 'Muatan tidak lengkap'], 400);
            }
        }

        // ---------- 2. Memeriksa tanda tangan ----------
        $hitungan = hash(
            'sha512',
            $muatan['order_id']
                . $muatan['status_code']
                . $muatan['gross_amount']
                . config('midtrans.signature_key')
        );

        $sah = hash_equals($hitungan, (string) $muatan['signature_key']);

        Log::info('Diagnostik signature Midtrans', [
            'merchant_id' => $muatan['merchant_id'] ?? null,
            'order_id' => $muatan['order_id'],
            'status_code' => $muatan['status_code'],
            'gross_amount' => $muatan['gross_amount'],
            'signature_match' => $sah,
            'server_key_length' => strlen(
                (string) config('midtrans.server_key')
            ),
        ]);


        // ---------- 3. Mencari pesanannya ----------
        $pesanan     = Pesanan::where('midtrans_order_id', $muatan['order_id'])->first();
        $orderIdLama = false;

        if (! $pesanan) {
            // order_id dari percobaan bayar sebelumnya (Pertemuan 9 §H.4):
            // INV-20261029-A7K3-261030143052  →  INV-20261029-A7K3
            $kode        = preg_replace('/-\d{12}$/', '', $muatan['order_id']);
            $pesanan     = Pesanan::where('kode_pesanan', $kode)->first();
            $orderIdLama = (bool) $pesanan;
        }

        // ---------- 4. Mencatat, apa pun hasilnya ----------
        Pembayaran::create([
            'pesanan_id'         => $pesanan?->id,
            'order_id'           => $muatan['order_id'],
            'transaction_id'     => $muatan['transaction_id'] ?? null,
            'transaction_status' => $muatan['transaction_status'] ?? null,
            'fraud_status'       => $muatan['fraud_status'] ?? null,
            'payment_type'       => $muatan['payment_type'] ?? null,
            'status_code'        => $muatan['status_code'],
            'gross_amount'       => $muatan['gross_amount'],
            'signature_sah'      => $sah,
            'muatan'             => $muatan,
        ]);

        // ---------- 5. Menolak yang tidak sah ----------
        if (! $sah) {
            Log::warning('Tanda tangan notifikasi Midtrans tidak sah', [
                'order_id' => $muatan['order_id'],
                'ip'       => $request->ip(),
            ]);

            return response()->json(['pesan' => 'Tanda tangan tidak sah'], 403);
        }

        if (! $pesanan) {
            Log::warning('Notifikasi untuk pesanan yang tidak dikenal', [
                'order_id' => $muatan['order_id'],
            ]);

            // Jawab 200 agar Midtrans berhenti mencoba ulang —
            // pesanan ini memang tidak akan pernah ada
            return response()->json(['pesan' => 'Pesanan tidak ditemukan'], 200);
        }

        // ---------- 6. order_id lama hanya boleh melunasi ----------
        // Kabar "kedaluwarsa" dari halaman bayar lama tidak boleh
        // membatalkan halaman bayar baru yang sedang dipakai pembeli
        if (
            $orderIdLama
            && ! in_array($muatan['transaction_status'] ?? '', ['settlement', 'capture'], true)
        ) {
            Log::info('Notifikasi order_id lama diabaikan', [
                'order_id'           => $muatan['order_id'],
                'transaction_status' => $muatan['transaction_status'] ?? null,
            ]);

            return response()->json(['pesan' => 'Diabaikan: order_id lama'], 200);
        }

        // ---------- 7. Menerapkan ----------
        $hasil = Midtrans::terapkan($pesanan, $muatan);

        return response()->json([
            'pesan'        => 'Diterima',
            'status_bayar' => $hasil,
        ], 200);
    }
}
