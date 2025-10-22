<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function index()
{
    $totalProduk = Product::count();
    $transaksiHariIni = Transaction::whereDate('created_at', today())->count();
    $menungguKonfirmasi = Transaction::where('status', 'pending')->count();
    $totalPendapatan = Transaction::where('status', 'selesai')->sum('total_harga');

    return view('dashboard', compact(
        'totalProduk',
        'transaksiHariIni',
        'menungguKonfirmasi',
        'totalPendapatan'
    ));
}

}
