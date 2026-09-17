<?php

namespace App\Http\Controllers;

use App\App\Data\ProdukDummy;
use App\Data\ProdukDummy as DataProdukDummy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home()
    {
        //dari ProdukDummy
        $produkPopuler = DataProdukDummy::semua();

        return view('user-front.home', compact('produkPopuler'));
    }

    public function kontak()
    {
        return view('user-front.kontak');
    }
}
