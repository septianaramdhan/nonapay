<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\AuthController;

// login & logout
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// produk (kelola produk)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.create');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
Route::resource('produk', ProdukController::class);

// transaksi (konfirmasi pembayaran)
Route::get('/transactions/create', [TransaksiController::class, 'create'])->name('transactions.create');
Route::post('/transactions/store', [TransaksiController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}', [TransaksiController::class, 'show'])->name('transactions.show');

// struk (cetak struk)
Route::get('/struk', [StrukController::class, 'index'])->name('struk.index');
Route::get('/struk/print/{id}', [StrukController::class, 'print'])->name('struk.print');
