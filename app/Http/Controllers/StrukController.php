<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Struk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;

class StrukController extends Controller
{
    public function index()
    {
        $struks = Struk::with('transaksi')->latest()->get();
        return view('struk.index', [
            'title' => 'Cetak Struk',
            'struks' => $struks
        ]);
    }

    public function print($id)
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);

        $struk = Struk::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'tanggal_cetak' => Carbon::now(),
        ]);

        return view('struk.print', [
            'title' => 'Struk Pembayaran',
            'transaksi' => $transaksi,
            'struk' => $struk
        ]);
    }
}
