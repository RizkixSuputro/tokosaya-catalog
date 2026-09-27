<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * menampilkan daftar kategori
     */
    public function index()
    {
        $daftarKategori = Kategori::withCount('produks')
            ->orderBy('nama_kategori')
            ->get();

        return view('back_office.kategori.index', compact('daftarKategori'));
    }

    /**
     * menampilkan formulir tambah
     */
    public function create()
    {
        return view('back_office.kategori.create');
    }

    /**
     * menyimpan kategori baru
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'nama_kategori' => ['required', 'string', 'max:100', 'unique:kategoris,nama_kategori'],
                'deskripsi' => ['nullable', 'string'],
            ],
            [
                'nama_kategori.required' => 'Nama kategori wajib diisi.',
                'nama_kategori.unique' => 'Kategori dengan nama itu sudah ada.',
                'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
            ]
        );

        $data['slug'] = Str::slug($data['nama_kategori']);

        Kategori::create($data);

        return redirect()
            ->route('back_office.kategori.index')
            ->with('sukses', 'kategori berhasil ditambahkan');
    }


    /**
     * menampilkan formulir edit
     */
    public function edit(Kategori $kategori)
    {
        return view('back_office.kategori.edit', compact('kategori'));
    }

    /**
     * menyimpan perubahan
     */
    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategoris,nama_kategori, ' . $kategori->id,
            ],
            'deskripsi' => ['nullable', 'string'],
        ]);
        $data['slug'] = Str::slug($data['nama_kategori']);

        $kategori->update($data);

        return redirect()
            ->route('back_office.kategori.index')
            ->with('sukses', 'kategori berhahsil diperbarui');
    }

    /**
     * menghapus kategori
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->produks()->count() > 0) {
            return redirect()
                ->route('back_office.kategori.index')
                ->with('gagal', 'kategori tidak bisa dihapus karena masih memiliki produk');
        }

        $kategori->delete();

        return redirect()
            ->route('back_office.kategori.index')
            ->with('sukses', 'kategori berhasil dihapus');
    }
}
