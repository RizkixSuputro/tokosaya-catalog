<?php

use App\Http\Controllers\BackOffice\AuthController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');


Route::get('/produk', [ProdukController::class, 'index'])->name('daftar-produk');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('detail-produk');

Route::get('/kontak', function () {
    return view('user-front.kontak');
})->name('kontak');


Route::prefix('back-office')->name('back_office.')->group(function () {

    // bisa diakases orang luar
    Route::get('/login', [AuthController::class, 'tampilkanForm'])->name('login');
    Route::post('/login', [AuthController::class, 'proses'])->name('proses_login');

    // hanya akses admin
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
