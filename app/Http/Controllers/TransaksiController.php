<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Struk;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('detailTransaksi')->latest()->get();
        return view('transactions.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('transactions.create', compact('produks'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id_produk' => 'required|exists:produks,id_produk',
                'jumlah' => 'required|integer|min:1',
                'metode_pembayaran' => 'required|in:cash,transfer',
                'uang_diterima' => 'nullable|numeric'
            ]);

            $produk = Produk::findOrFail($request->id_produk);
            $total_harga = $produk->harga * $request->jumlah;

            $transaksi = Transaksi::create([
                'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 1,
                'tanggal' => Carbon::now(),
                'total_harga' => $total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'uang_diterima' => $request->uang_diterima ?? 0,
                'kembalian' => $request->metode_pembayaran === 'cash'
                    ? ($request->uang_diterima - $total_harga)
                    : 0,
            ]);

            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_produk' => $request->id_produk,
                'jumlah' => $request->jumlah,
                'subtotal' => $total_harga,
            ]);

            // kurangi stok produk
            $produk->stok -= $request->jumlah;
            $produk->save();

            // bikin struk otomatis (buat ditampilin di halaman struk)
            Struk::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'tanggal_cetak' => Carbon::now(),
            ]);

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}