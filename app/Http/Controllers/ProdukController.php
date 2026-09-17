<?php

namespace App\Http\Controllers;

use App\Data\ProdukDummy;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    //
    public function index()
    {

        // memanggil data dari ProdukDummy
        $daftarProduk = ProdukDummy::semua();


        return view('user-front.products.daftar-produk', compact('daftarProduk'));
    }

    public function show(int $id)
    {
        $produk = ProdukDummy::cari($id);


        // Kalau produk tidak ditemukan, tampilkan halaman 404
        abort_if($produk === null, 404);

        return view('user-front.products.detail-produk', compact('produk'));
    }
}
