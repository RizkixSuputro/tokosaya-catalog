<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\User;
use App\Data\ProdukDummy;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $ringkasan = [
            'produk' => 3,
            'kategori' => 3,
            'pesanan_baru' => 0,
            'admin_aktif'  => User::where('role', 'admin')->count(),
        ];

        return view('back_office.dashboard', compact('ringkasan'));
    }
}
