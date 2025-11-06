<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Struk;

class StrukController extends Controller
{
    public function index()
    {
        $struks = Struk::with('transaksi')->latest('tanggal_cetak')->get();
        return view('struk.index', compact('struks'));
    }

    public function print($id)
    {
        $struk = Struk::with('transaksi.detailTransaksi.produk')->findOrFail($id);
        return view('print', compact('struk'));
    }
}