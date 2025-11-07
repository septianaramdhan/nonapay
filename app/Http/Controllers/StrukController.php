<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Struk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class StrukController extends Controller
{
    public function index()
    {
        $struks = Struk::with('transaksi')->latest('tanggal_cetak')->get();
        return view('struk.index', compact('struks'));
    }
public function print($id)
{
    // Ambil struk + transaksi + detail + produk langsung dalam satu query
    $struk = Struk::with('transaksi.detailTransaksi.produk')->findOrFail($id);

    // Ambil transaksi utama
    $transaksi = $struk->transaksi;

    // Ambil detail transaksi (sudah auto include produk)
    $detailTransaksis = $transaksi->detailTransaksi ?? collect();

    return view('print', compact('struk', 'transaksi', 'detailTransaksis'));
}

}