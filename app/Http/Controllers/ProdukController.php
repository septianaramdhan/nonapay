<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    // 🧾 Menampilkan daftar produk
    public function index()
    {
        $produks = Produk::all();

        return view('produk.index', [
            'title' => 'Kelola Produk',
            'produks' => $produks
        ]);
    }
    

    // ➕ Form tambah produk
    public function create()
    {
        return view('produk.create', [
            'title' => 'Tambah Produk'
        ]);
    }

   public function search(Request $request)
{
    $keyword = $request->get('q');
    $produk = Produk::where('nama_produk', 'like', "%{$keyword}%")->limit(10)->get();

    return response()->json($produk);
}



    // 💾 Simpan produk baru
   public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0'
    ]);

    $idKasir = Session::get('kasir_id');

    if (!$idKasir) {
        return redirect()->back()->with('error', 'ID kasir tidak ditemukan di session!');
    }

    // Format ID produk: pd + idKasir (2 digit) + tanggal (ddmmyy)
    $tanggal = now()->format('dmy'); // contoh: 031125 (3 Nov 2025)
    $idProduk = 'pd' . str_pad($idKasir, 2, '0', STR_PAD_LEFT) . $tanggal;

    Produk::create([
        'id_produk' => $idProduk,
        'id_kasir' => $idKasir,
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->route('produk.index')
        ->with('success', 'Produk berhasil ditambahkan dengan ID: ' . $idProduk);
}


    // ✏️ Form edit produk
  public function edit($id)
{
    $produk = Produk::findOrFail($id);
    return view('produk.edit', compact('produk'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
    ]);

    $produk = Produk::findOrFail($id);
    $produk->update([
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->route('produk.index')->with('success', 'Perubahan berhasil disimpan!');
}

    // 🗑️ Hapus produk
    public function destroy($id)
    {
        Produk::where('id_produk', $id)->delete();
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
    
}
