<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function create()
    {
        $produks = Produk::all();
        return view('transactions.index', [
            'title' => 'Konfirmasi Pembayaran',
            'produks' => $produks
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk' => 'required|array',
            'produk.*' => 'exists:produks,id_produk',
            'jumlah.*' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'uang_diterima' => 'nullable|numeric',
        ]);

        $totalHarga = 0;

        foreach ($request->produk as $index => $id_produk) {
            $produk = Produk::find($id_produk);
            $totalHarga += $produk->harga * $request->jumlah[$index];
        }

        $transaksi = Transaksi::create([
            'id_kasir' => Session::get('kasir_id'),
            'tanggal' => Carbon::now(),
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'uang_diterima' => $request->uang_diterima,
            'kembalian' => $request->uang_diterima ? $request->uang_diterima - $totalHarga : 0,
        ]);

        foreach ($request->produk as $index => $id_produk) {
            $produk = Produk::find($id_produk);
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_produk' => $id_produk,
                'jumlah' => $request->jumlah[$index],
                'subtotal' => $produk->harga * $request->jumlah[$index],
            ]);

            $produk->stok -= $request->jumlah[$index];
            $produk->save();
        }

        return redirect()->route('struk.index')->with('success', 'Transaksi berhasil dibuat!');
    }
}
