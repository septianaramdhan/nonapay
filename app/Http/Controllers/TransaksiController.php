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
        // Ambil transaksi + detail transaksi + produk
        $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);

        $detailTransaksis = $transaksi->detailTransaksi ?? collect();

        return view('transactions.show', compact('transaksi', 'detailTransaksis'));
    }

   public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // ✅ Validasi input
        $request->validate([
            'id_produk' => 'required|array',
            'id_produk.*' => 'exists:produks,id_produk',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'uang_diterima' => 'nullable|numeric|max:999999999999',
            'jenis_transfer' => 'nullable|string',
            'no_rekening' => 'nullable|string|max:20',
            'no_ewallet' => 'nullable|string|max:20',
            'atas_nama' => 'nullable|string|max:50',
        ]);

       // ✅ Validasi ewallet: 1 nomor hanya boleh punya 1 nama di ewallet yang sama
if ($request->metode_pembayaran === 'transfer' && in_array($request->jenis_transfer, ['DANA','OVO','GoPay','ShopeePay'])) {
    if ($request->no_ewallet && $request->atas_nama) {
        $transaksiSamaNo = \App\Models\Transaksi::where('tipe_transfer', 'ewallet')
            ->where('nama_ewallet', $request->jenis_transfer)
            ->where('nomor_ewallet', $request->no_ewallet)
            ->first();

        // Jika nomor sudah pernah digunakan di ewallet ini
        if ($transaksiSamaNo) {
            // tapi nama-nya beda → tolak
            if (strtolower(trim($transaksiSamaNo->nama_pengirim)) !== strtolower(trim($request->atas_nama))) {
                return back()->withInput()->with('errorl', 'Nomor e-wallet ' . $request->no_ewallet . ' sudah terdaftar di ' . $request->jenis_transfer . ' atas nama "' . $transaksiSamaNo->nama_pengirim . '". Tidak boleh digunakan dengan nama lain!');
            }
        }
    }

}


        // Hitung total harga
        $total_harga = 0;
        foreach ($request->id_produk as $index => $id_produk) {
            $produk = Produk::findOrFail($id_produk);
            $subtotal = $produk->harga * $request->jumlah[$index];
            $total_harga += $subtotal;
        }

        // Validasi uang diterima jika cash
        if ($request->metode_pembayaran === 'cash') {
            if (!$request->uang_diterima || $request->uang_diterima < $total_harga) {
                return back()->with('error', 'Uang diterima tidak boleh kurang dari total harga!');
            }
        }

        // Buat kode transaksi otomatis
        $tanggal = Carbon::now()->format('Ymd');
        $count = Transaksi::whereDate('tanggal', Carbon::today())->count() + 1;
        $kodeTransaksi = 'TRX' . $tanggal . '-' . $count;

        // Inisialisasi variabel transfer
        $tipe_transfer = null;
        $nama_bank = null;
        $nomor_rekening = null;
        $nama_ewallet = null;
        $nomor_ewallet = null;
        $nama_pengirim = null;

        // Jika transfer
        if ($request->metode_pembayaran === 'transfer') {
            $jenis = $request->jenis_transfer;

            if (in_array($jenis, ['BCA','BNI','BRI','Mandiri'])) {
                $tipe_transfer = 'bank';
                $nama_bank = $jenis;
                $nomor_rekening = $request->no_rekening;
                $nama_pengirim = $request->atas_nama;
            } elseif (in_array($jenis, ['DANA','OVO','GoPay','ShopeePay'])) {
                $tipe_transfer = 'ewallet';
                $nama_ewallet = $jenis;
                $nomor_ewallet = $request->no_ewallet;
                $nama_pengirim = $request->atas_nama;
            }
        }

        // Simpan transaksi utama
        $transaksi = Transaksi::create  ([
            'kode_transaksi' => $kodeTransaksi,
            'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 1,
            'tanggal' => Carbon::now(),
            'total_harga' => $total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'uang_diterima' => $request->metode_pembayaran === 'cash' ? $request->uang_diterima : $total_harga,
            'kembalian' => $request->metode_pembayaran === 'cash' ? ($request->uang_diterima - $total_harga) : 0,
            'tipe_transfer' => $tipe_transfer,
            'nama_bank' => $nama_bank,
            'nomor_rekening' => $nomor_rekening,
            'nama_ewallet' => $nama_ewallet,
            'nomor_ewallet' => $nomor_ewallet,
            'nama_pengirim' => $nama_pengirim,
        ]);

        // Simpan detail transaksi & kurangi stok
        foreach ($request->id_produk as $index => $id_produk) {
    $produk = Produk::findOrFail($id_produk);

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

    // 💾 Simpan detail transaksi dengan snapshot produk
    DetailTransaksi::create([
        'id_transaksi' => $transaksi->id_transaksi,
        'id_produk' => $produk->id_produk,
        'nama_produk' => $produk->nama_produk, // 🩶 snapshot nama produk
        'harga_saat_transaksi' => $produk->harga, // 🩶 snapshot harga produk
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
