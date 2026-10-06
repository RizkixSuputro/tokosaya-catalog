<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BahasaController extends Controller
{
    public const BAHASA_TERSEDIA = ['id', 'en'];

    public function ganti(Request $request, string $kode)
    {

        // tolak kdoe bahasa yang tidak ada dalam daftar
        if (!in_array($kode, self::BAHASA_TERSEDIA, true)) {
            abort(404);
        }
        $request->session()
            ->put('bahasa', $kode);

        // kembalikan pengunjung ke halaman sebelumnya
        return redirect()->back();
    }
}
