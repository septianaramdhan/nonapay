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
        $struks = Struk::with('transaksi')->orderBy('tanggal_cetak', 'desc')->get();
    
        return view('struk.index', compact('struks'));
    }
public function print($id)
{
    $struk = Struk::with('transaksi.detailTransaksi.produk')->findOrFail($id);
$transaksi = $struk->transaksi;
$detailTransaksis = $transaksi->detailTransaksi ?? collect();


    return view('print', compact('struk', 'transaksi', 'detailTransaksis'));
}


}