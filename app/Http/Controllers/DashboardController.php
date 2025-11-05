<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalProduk = Produk::count();
        $totalTransaksi = Transaksi::count();
        $transaksiHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();
        $totalPendapatan = Transaksi::sum('total_harga');
        $totalProdukTerjual = DetailTransaksi::sum('jumlah');

        // === Analitik Mingguan ===
        $labels = [];
        $data = [];

        // ambil 7 hari terakhir termasuk hari ini
        $hariIni = Carbon::today();

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = $hariIni->copy()->subDays($i);
            $labels[] = $tanggal->translatedFormat('l'); // tampilkan nama hari (Senin, Selasa, Rabu, dst)
            $jumlahTransaksi = Transaksi::whereDate('created_at', $tanggal)->count();
            $data[] = $jumlahTransaksi;
        }

        // === Donut Chart ===
        $cash = Transaksi::where('metode_pembayaran', 'cash')->count();
        $transfer = Transaksi::where('metode_pembayaran', 'transfer')->count();

        // kirim semua data ke view
        return view('transactions.dashboard', [
            'title' => 'Dashboard',
            'totalProduk' => $totalProduk,
            'totalTransaksi' => $totalTransaksi,
            'transaksiHariIni' => $transaksiHariIni,
            'totalPendapatan' => $totalPendapatan,
            'totalProdukTerjual' => $totalProdukTerjual,
            'chartLabels' => json_encode($labels),
            'chartData' => json_encode($data),
            'cash' => $cash,
            'transfer' => $transfer,
        ]);
    }
}