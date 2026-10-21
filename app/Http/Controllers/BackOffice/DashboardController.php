<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\User;
use App\Models\Kategori;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $ringkasan = [
            'produk'       => Produk::count(),
            'kategori'     => Kategori::count(),
            'pesanan_baru' => Pesanan::where('status', 'baru')->count(),
            'admin_aktif'  => User::where('role', 'admin')->count(),
        ];

        return view('back_office.dashboard', compact('ringkasan'));
    }
}
