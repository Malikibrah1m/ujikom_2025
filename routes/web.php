<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SupplierController;
use App\Http\Middleware\CheckRoleMiddleware;

//=======================
// ROUTE PUBLIK (TANPA LOGIN)
//=======================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

//=======================
// ROUTE PRIVAT (HARUS LOGIN)
//=======================
Route::middleware(['auth',CheckRoleMiddleware::class])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Redirect utama
    Route::get('/', function () {
        return redirect()->route('supplier.index');
    });

        // Manajemen User
    Route::resource('users', App\Http\Controllers\UserController::class)->except(['show', 'create', 'edit']);
    Route::resource('supplier', SupplierController::class);
    Route::resource('pembelian', PembelianController::class)->except(['edit', 'update']);
    Route::resource('pelanggan', PelangganController::class);
    Route::get('/pembelian/export/pdf', [PembelianController::class, 'export'])->name('pembelian.export');

   
    
    // Penjualan
    Route::resource('obat', ObatController::class)->withoutMiddleware(CheckRoleMiddleware::class);
    Route::resource('penjualan', PenjualanController::class)->except(['edit', 'update'])->withoutMiddleware(CheckRoleMiddleware::class);
    Route::get('/penjualan/export/pdf', [PenjualanController::class, 'exportPDF'])->name('penjualan.export')->withoutMiddleware(CheckRoleMiddleware::class);
    Route::get('/get-pelanggan-data/{id}', [PenjualanController::class, 'getPelangganData'])->withoutMiddleware(CheckRoleMiddleware::class);
    
    // Pembelian
});