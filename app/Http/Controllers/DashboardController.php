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
    $start = now()->startOfWeek();
    $end = now()->endOfWeek();
    $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

    $chartLabels = [];
    $chartData = [];

    foreach ($days as $i => $day) {
        $dayDate = $start->copy()->addDays($i);
        $chartLabels[] = $day;
        $chartData[] = Transaksi::whereDate('created_at', $dayDate)->count();
    }

    // Statistik kartu untuk minggu ini
    $totalProduk = Produk::count();
    $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();
    $totalTransaksi = Transaksi::whereBetween('created_at', [$start, $end])->count();
    $totalPendapatan = Transaksi::whereBetween('created_at', [$start, $end])->sum('total_harga');
    $cash = Transaksi::whereBetween('created_at', [$start, $end])->where('metode_pembayaran','cash')->count();
    $transfer = Transaksi::whereBetween('created_at', [$start, $end])->where('metode_pembayaran','transfer')->count();

    return view('transactions.dashboard', [
        'title' => 'Dashboard',
        'totalProduk' => $totalProduk,
        'transaksiHariIni' => $transaksiHariIni,
        'totalTransaksi' => $totalTransaksi,
        'totalPendapatan' => $totalPendapatan,
        'chartLabels' => json_encode($chartLabels),
        'chartData' => json_encode($chartData),
        'cash' => $cash,
        'transfer' => $transfer,
        'scaleY' => 20 // default Y-axis
    ]);
}

public function filter(Request $request)
{
    $periode = $request->periode;
    $date = $request->start ? Carbon::parse($request->start) : now();

    $query = Transaksi::query();
    $chartLabels = [];
    $chartData = [];
    $start = $end = null;

    if ($periode === 'harian') {
        $start = $date->startOfWeek();
        $end = $date->endOfWeek();
        $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        foreach($days as $i => $day){
            $dayDate = $start->copy()->addDays($i);
            $chartLabels[] = $day;
            $chartData[] = $query->whereDate('created_at', $dayDate)->count();
        }
        $title = 'Penjualan Minggu ' . $start->weekOfYear;
    } elseif ($periode === 'mingguan') {
        $startMonth = $date->copy()->startOfMonth();
        for($week = 1; $week <= 4; $week++){
            $weekStart = $startMonth->copy()->addWeeks($week-1);
            $weekEnd = $weekStart->copy()->endOfWeek();
            $chartLabels[] = 'Minggu ' . $week;
            $chartData[] = $query->whereBetween('created_at', [$weekStart, $weekEnd])->count();
        }
        $title = 'Penjualan Bulan ' . $date->translatedFormat('F');
    } elseif ($periode === 'bulanan') {
        for($m=1; $m<=12; $m++){
            $monthStart = Carbon::create($date->year,$m,1)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();
            $chartLabels[] = $monthStart->translatedFormat('F');
            $chartData[] = $query->whereBetween('created_at', [$monthStart,$monthEnd])->count();
        }
        $title = 'Penjualan Tahun ' . $date->year;
    } else {
        $chartLabels[] = $date->format('d/m/Y');
        $chartData[] = $query->whereDate('created_at', $date)->count();
        $title = 'Penjualan ' . $date->format('d/m/Y');
    }

    $filteredTransaksi = $query
        ->when($periode==='custom', fn($q) => $q->whereDate('created_at', $date))
        ->when($periode==='harian', fn($q) => $q->whereBetween('created_at', [$start, $end]))
        ->when($periode==='mingguan', fn($q) => $q->whereMonth('created_at', $date->month))
        ->when($periode==='bulanan', fn($q) => $q->whereYear('created_at', $date->year))
        ->get();

    return response()->json([
        'title' => $title,
        'chartLabels' => $chartLabels,
        'chartData' => $chartData,
        'cash' => $filteredTransaksi->where('metode_pembayaran','cash')->count(),
        'transfer' => $filteredTransaksi->where('metode_pembayaran','transfer')->count(),
        'totalPendapatan' => $filteredTransaksi->sum('total_harga'),
        'totalTransaksi' => $filteredTransaksi->count(),
        'transaksiHariIni' => Transaksi::whereDate('created_at', today())->count(),
    ]);
}
}