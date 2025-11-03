<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();
        $totalPendapatan = Transaksi::sum('total_harga');

        // Analitik transaksi mingguan
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $labels[] = $tanggal->translatedFormat('l'); // Senin, Selasa, dst
            $data[] = Transaksi::whereDate('created_at', $tanggal)->count();
        }

        // Donut chart metode pembayaran
        $cash = Transaksi::where('metode_pembayaran', 'cash')->count();
        $transfer = Transaksi::where('metode_pembayaran', 'transfer')->count();

        return view('transactions.dashboard', [
            'title' => 'Dashboard',
            'totalProduk' => $totalProduk,
            'transaksiHariIni' => $transaksiHariIni,
            'totalPendapatan' => $totalPendapatan,
            'chartLabels' => json_encode($labels),
            'chartData' => json_encode($data),
            'cash' => $cash,
            'transfer' => $transfer,
        ]);
    }
}
