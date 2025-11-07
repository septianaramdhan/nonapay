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

    public function show($id)
    {
        // Ambil transaksi dengan detail dan produk sekaligus
        $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);

        // Ambil data detail transaksi terpisah untuk ditampilkan di tabel
        $detailTransaksis = DetailTransaksi::with('produk')
            ->where('id_transaksi', $transaksi->id_transaksi)
            ->get();

        return view('transactions.show', compact('transaksi', 'detailTransaksis'));
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

        // Hitung total harga semua produk
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

        // Buat kode transaksi otomatis
        $tanggal = Carbon::now()->format('Ymd');
        $count = Transaksi::whereDate('tanggal', Carbon::today())->count() + 1;
        $kodeTransaksi = 'TRX' . $tanggal . '-' . $count;

        // Simpan transaksi utama
        $transaksi = Transaksi::create([
            'kode_transaksi' => $kodeTransaksi,
            'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 1,
            'tanggal' => Carbon::now(),
            'total_harga' => $total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'uang_diterima' => $request->metode_pembayaran === 'cash'
                ? $request->uang_diterima
                : $total_harga,
            'kembalian' => $request->metode_pembayaran === 'cash'
                ? ($request->uang_diterima - $total_harga)
                : 0,
        ]);

        // Simpan detail transaksi per produk
        foreach ($request->id_produk as $index => $id_produk) {
            $produk = Produk::findOrFail($id_produk);

            // Cek stok
            if ($produk->stok <= 0) {
                DB::rollBack();
                return back()->with('error', "Produk '{$produk->nama_produk}' stoknya sudah habis!");
            }

            if ($request->jumlah[$index] > $produk->stok) {
                DB::rollBack();
                return back()->with('error', "Jumlah pembelian '{$produk->nama_produk}' melebihi stok ({$produk->stok})!");
            }

            // Kurangi stok
            $produk->stok -= $request->jumlah[$index];
            $produk->save();

            // 💾 Simpan ke tabel detail_transaksis
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_produk' => $produk->id_produk,
                'jumlah' => $request->jumlah[$index],
                'subtotal' => $produk->harga * $request->jumlah[$index],
            ]);
        }

        // Buat struk otomatis
        $countToday = Struk::whereDate('created_at', Carbon::today())->count() + 1;
        $idStruk = 'NSTR' . Carbon::now()->format('Ymd') . '-' . $countToday;

        Struk::create([
            'id_struk' => $idStruk,
            'id_transaksi' => $transaksi->id_transaksi,
            'tanggal_cetak' => Carbon::now()->toDateTimeString(),
        ]);

        DB::commit();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan! Struk siap dicetak.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
    }
}
}