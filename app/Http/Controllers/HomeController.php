<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home()
    {
        $produkPopuler = Produk::with('kategori')
            ->where('status', 'aktif')
            ->latest()
            ->take(4)
            ->get();

        return view('user-front.home', compact('produkPopuler'));
    }

    public function kontak()
    {
        return view('user-front.kontak');
    }
}
