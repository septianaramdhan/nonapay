<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        $totalRevenue = Transaction::sum('total_price');

        // data dummy buat chart
        $salesLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $salesData = [120000, 150000, 90000, 200000, 180000, 240000, 130000];
        $cashTotal = 60;
        $transferTotal = 40;

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalProducts' => $totalProducts,
            'todayTransactions' => $todayTransactions,
            'totalRevenue' => $totalRevenue,
            'salesLabels' => $salesLabels,
            'salesData' => $salesData,
            'cashTotal' => $cashTotal,
            'transferTotal' => $transferTotal,
        ]);
    }
}
