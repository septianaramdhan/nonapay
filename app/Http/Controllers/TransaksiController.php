<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Struk;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            'id_produk' => 'required|array',
            'id_produk.*' => 'exists:produks,id_produk',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'uang_diterima' => 'nullable|numeric',
        ]);

        $total_harga = 0;

        // hitung total harga semua produk
        foreach ($request->id_produk as $index => $id_produk) {
            $produk = Produk::findOrFail($id_produk);
            $subtotal = $produk->harga * $request->jumlah[$index];
            $total_harga += $subtotal;
        }

        // Validasi uang diterima (kalau cash)
        if ($request->metode_pembayaran === 'cash') {
            if (!$request->uang_diterima || $request->uang_diterima < $total_harga) {
                return back()->with('error', 'Uang diterima tidak boleh kurang dari total harga!');
            }
        }

        // Simpan transaksi utama
        $transaksi = Transaksi::create([
            'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 1,
            'tanggal' => Carbon::now(),
            'total_harga' => $total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'uang_diterima' => $request->metode_pembayaran === 'cash'
                ? $request->uang_diterima
                : $total_harga, // kalau transfer langsung set = total
            'kembalian' => $request->metode_pembayaran === 'cash'
                ? ($request->uang_diterima - $total_harga)
                : 0,
        ]);

        // Simpan detail transaksi per produk
      foreach ($request->id_produk as $index => $id_produk) {
    $produk = Produk::findOrFail($id_produk);

    // 🚫 Cek stok habis
    if ($produk->stok <= 0) {
        DB::rollBack();
        return back()->with('error', "Produk '{$produk->nama_produk}' stoknya sudah habis!");
    }

    // 🚫 Cek kalo beli lebih dari stok tersedia
    if ($request->jumlah[$index] > $produk->stok) {
        DB::rollBack();
        return back()->with('error', "Jumlah pembelian '{$produk->nama_produk}' melebihi stok yang tersedia ({$produk->stok})!");
    }

    $subtotal = $produk->harga * $request->jumlah[$index];

            // Kurangi stok produk
            $produk->stok -= $request->jumlah[$index];
            $produk->save();
        }

        // Buat struk otomatis
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