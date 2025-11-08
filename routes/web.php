<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Models\Produk;

// login & logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// produk (kelola produk)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk', [ProdukController::class, 'store'])->name('produk.create');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');
Route::resource('produk', ProdukController::class);


// Transaksi (Konfirmasi Pembayaran)
Route::get('/transactions', [TransaksiController::class, 'index'])->name('transactions.index'); // ini yang utama dulu
Route::get('/transactions/create', [TransaksiController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransaksiController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}', [TransaksiController::class, 'show'])->name('transactions.show');

// 🔍 route ajax untuk pencarian produk
Route::get('/produk/search', function (Request $request) {
    $query = $request->q;
    $produks = \App\Models\Produk::where('nama_produk', 'like', "%$query%")->get();
    return response()->json($produks);
});

Route::get('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');



// struk (cetak struk)
Route::get('/struk', [StrukController::class, 'index'])->name('struk.index');
Route::get('/struk/print/{id}', [StrukController::class, 'print'])->name('print');


