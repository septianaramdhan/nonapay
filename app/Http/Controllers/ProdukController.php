<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use Carbon\Carbon;


class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function edit($id)
{
    $produk = Produk::findOrFail($id);
    return view('produk.edit', compact('produk'));
}

public function search(Request $request)
{
    $query = $request->q;

    $produks = Produk::query()
        ->when($query, function ($q) use ($query) {
            $q->where('nama_produk', 'like', "%{$query}%");
        })
        ->select('id_produk', 'nama_produk', 'harga')
        ->limit(10)
        ->get();

    if ($produks->isEmpty()) {
        return response()->json([
            ['id_produk' => null, 'nama_produk' => 'Produk Tidak Ditemukan']
        ]);
    }

    return response()->json($produks);
}
  // PRODUKCONTROLLER
public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required|string|max:100|unique:produks,nama_produk,NULL,id_produk,deleted_at,NULL',
        'harga' => 'required|numeric|min:1|max:500000',
        'stok' => 'required|integer|min:1|max:1000',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'nama_produk.unique' => 'Produk dengan nama ini sudah ada, barang tidak boleh duplikat',
        'harga.max' => 'Max Harga 500.000',
        'stok.max' => 'Max Stok 1000',
    ]);

    $tanggal = Carbon::now()->format('Ymd');
    $count = Produk::whereDate('created_at', Carbon::today())->count() + 1;
    $id_produk = 'PRD' . $tanggal . '-' . $count;

    // ⬇️ SIMPAN GAMBAR
    $namaFile = null;
    if ($request->hasFile('gambar')) {
        $namaFile = time() . '.' . $request->gambar->extension();
        $request->gambar->storeAs('public/produk', $namaFile);
    }

    Produk::create([
        'id_produk' => $id_produk,
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 1,
        'gambar' => $namaFile, // ⬅️ SIMPAN NAMA FILE
    ]);

    return redirect()->route('produk.index')
        ->with('success', "Produk berhasil ditambahkan dengan ID $id_produk!");
}


public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required|string|max:100|unique:produks,nama_produk,' . $id . ',id_produk,deleted_at,NULL',
        'harga' => 'required|numeric|min:1|max:500000',
        'stok' => 'required|integer|min:1|max:1000',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'harga.max' => 'Max Harga 500.000',
        'stok.max' => 'Max Stok 1000',
    ]);

    $produk = Produk::findOrFail($id);

    // ⬇️ SIMPAN GAMBAR JIKA ADA FILE BARU
    if ($request->hasFile('gambar')) {
        if ($produk->gambar && file_exists(storage_path('app/public/produk/' . $produk->gambar))) {
            unlink(storage_path('app/public/produk/' . $produk->gambar));
        }

        $namaFile = time() . '.' . $request->gambar->extension();
        $request->gambar->storeAs('public/produk', $namaFile);
        $produk->gambar = $namaFile;
    }

    // ⬇️ UPDATE FIELD LAIN
    $produk->nama_produk = $request->nama_produk;
    $produk->harga = $request->harga;
    $produk->stok = $request->stok;
    $produk->save();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
}


public function destroy($id_produk)
{
    $produk = Produk::where('id_produk', $id_produk)->firstOrFail();
    $produk->delete();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
}




}