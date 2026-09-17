<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/kontak', [HomeController::class, 'kontak']);

Route::get('/produk', [ProdukController::class, 'index'])->name('daftar-produk');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('detail-produk');

Route::get('/kontak', function () {
    return view('user-front.kontak');
})->name('kontak');

Route::get('/admin', function () {
    return view('admin.dashboard');
});
