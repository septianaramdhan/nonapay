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
        'nama_produk' => 'required|string|max:100|unique:produks,nama_produk',
        'harga' => 'required|numeric|min:1|max:500000',
        'stok' => 'required|integer|min:1|max:1000',
    ], [
        'nama_produk.unique' => 'Produk dengan nama ini sudah ada, barang tidak boleh duplikat',
        'harga.max' => 'Max Harga 500.000',
        'stok.max' => 'Max Stok 1000',
    ]);

    $tanggal = Carbon::now()->format('Ymd');
    $count = Produk::whereDate('created_at', Carbon::today())->count() + 1;
    $id_produk = 'PRD' . $tanggal . '-' . $count;

    Produk::create([
        'id_produk' => $id_produk,
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 1,
    ]);

    return redirect()->route('produk.index')
        ->with('success', "Produk berhasil ditambahkan dengan ID $id_produk!");
}

public function update(Request $request, $id)
{
    
    $request->validate([
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric|min:1|max:500000',
        'stok' => 'required|integer|min:1|max:1000',
    ], [
        'harga.max' => 'Max Harga 500.000',
        'stok.max' => 'Max Stok 1000',
    ]);

    $produk = \App\Models\Produk::findOrFail($id);
    $produk->update($request->all());
    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
}

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
    


}