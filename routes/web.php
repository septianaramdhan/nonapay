<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Models\Produk;

// ======================
// 🔐 LOGIN & LOGOUT
// ======================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================
// 🏠 DASHBOARD
// ======================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');

// ======================
// 📦 PRODUK
// ======================


// 🔍 Pencarian produk (HARUS di atas resource)
Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');

// Resource route produk
Route::resource('produk', ProdukController::class);

// Kalau mau pastikan route manual tetap bisa
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// ======================
// 💰 TRANSAKSI
// ======================
Route::get('/transactions', [TransaksiController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransaksiController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransaksiController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}', [TransaksiController::class, 'show'])->name('transactions.show');

// ======================
// 🧾 STRUK
// ======================
Route::get('/struk', [StrukController::class, 'index'])->name('struk.index');
Route::get('/struk/print/{id}', [StrukController::class, 'print'])->name('print');
