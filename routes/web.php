<?php

use App\Http\Controllers\BackOffice\AuthController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\BackOffice\KategoriController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BackOffice\ProdukController as ProdukBackOffice;
use App\Http\Controllers\BahasaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/produk', [ProdukController::class, 'index'])->name('daftar-produk');
// Cari produk berdasarkan slug
Route::get('/produk/{produk:slug}', [ProdukController::class, 'show'])->name('produk.show');

Route::get('/kontak', function () {
    return view('user-front.kontak');
})->name('kontak');

Route::get('/bahasa/{kode}', [BahasaController::class, 'ganti'])->name('bahasa.ganti');

Route::prefix('back-office')->name('back_office.')->group(function () {

    // bisa diakases orang luar
    Route::get('/login', [AuthController::class, 'tampilkanForm'])->name('login');
    Route::post('/login', [AuthController::class, 'proses'])->name('proses_login');

    // hanya akses admin
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // semua function yang ada di KategoriController akan muncul di dalam kode routes
        Route::resource('kategori', KategoriController::class)->except(['show']);
    });

    // semua function yang ada di ProdukController akan muncul didalam kode route
    Route::resource('produk', ProdukBackOffice::class)->except(['show']);
});
