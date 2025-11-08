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

  // PRODUKCONTROLLER
public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric|min:1|max:500000',
        'stok' => 'required|integer|min:1|max:1000',
    ], [
        'harga.max' => 'Ga realistis, dosa lho korupsi',
        'stok.max' => 'Mana punya modal segitu',
    ]);

  // 🩶 Generate ID produk otomatis
    $tanggal = Carbon::now()->format('Ymd');
    $count = \App\Models\Produk::whereDate('created_at', Carbon::today())->count() + 1;
    $id_produk = 'PRD' . $tanggal . '-' . $count;

    // 🩶 Simpan produk baru
    \App\Models\Produk::create([
        'id_produk' => $id_produk,
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 6, // fallback kalau belum login
    ]);

    return redirect()->route('produk.index')->with('success', "Produk berhasil ditambahkan dengan ID $id_produk!");
}

public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk' => 'required|string|max:100',
        'harga' => 'required|numeric|min:1|max:500000',
        'stok' => 'required|integer|min:1|max:1000',
    ], [
        'harga.max' => 'Ga realistis, dosa lho korupsi 😭',
        'stok.max' => 'Mana punya modal segitu 😭',
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