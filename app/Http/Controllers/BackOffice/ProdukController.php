<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Daftar Produk
     */
    public function index()
    {
        $daftarProduk = Produk::with('kategori')->latest()->paginate(10);

        return view('back_office.produk.index', compact('daftarProduk'));
    }

    /**
     * Formulir Tambah
     */
    public function create()
    {
        $daftarKategori = Kategori::orderBy('nama_kategori')->get();

        return view('back_office.produk.create', compact('daftarKategori'));
    }

    /**
     *   Menyimpan Produk Baru
     */
    public function store(Request $request)
    {
        $data = $this->periksaIsian($request);

        // Simpan gambar bila ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $data['slug'] = Str::slug($data['nama_produk']) . '-' . Str::random(5);

        Produk::create($data);

        return redirect()
            ->route('back_office.produk.index')
            ->with('sukses', 'Produk berhasil ditambahkan');
    }

    /**
     * Formulir Edit
     */
    public function edit(Produk $produk)
    {
        $daftarKategori = Kategori::orderBy('nama_kategori')->get();

        return view('back_office.produk.edit', compact('produk', 'daftarKategori'));
    }

    /**
     * Menyimpan perubahan
     */
    public function update(Request $request, Produk $produk)
    {
        $data = $this->periksaIsian($request);

        if ($request->hasFile('gambar')) {
            // hapus gambar lama biar tidak menumpuk
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()
            ->route(('back_office.produk.index'))
            ->with('sukses', 'Produk berhasil di perbarui');
    }

    /**
     * Menghapus produk
     */
    public function destroy(Produk $produk)
    {
        // Hapus gambar juga (jangan tinggalkan sampah)
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()
            ->route('back_office.produk.index')
            ->with('sukses', 'Produk berhasil dihapus');
    }

    private function periksaIsian(Request $request): array
    {
        return $request->validate([
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'nama_produk'  => ['required', 'string', 'max:200'],
            'kode_produk'  => ['nullable', 'string', 'max:50'],
            'deskripsi'    => ['nullable', 'string'],
            'harga'        => ['required', 'numeric', 'min:0'],
            'harga_coret'  => ['nullable', 'numeric', 'min:0', 'gt:harga'],
            'stok'         => ['required', 'integer', 'min:0'],
            'berat'        => ['required', 'integer', 'min:0'],
            'status'       => ['required', 'in:aktif,nonaktif'],
            'gambar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.numeric'        => 'Harga harus berupa angka.',
            'harga_coret.gt'       => 'Harga coret harus lebih besar dari harga jual.',
            'gambar.image'         => 'Berkas yang diunggah harus berupa gambar.',
            'gambar.max'           => 'Ukuran gambar maksimal 2 MB.',
        ]);
    }
}
