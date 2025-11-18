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
        return view('produks.index', compact('produks'));
    }

    public function create()
    {
        return view('produks.create');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produks.edit', compact('produk'));
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


    // ===================================================
    // STORE PRODUK — FIX ID & FIX UPLOAD GAMBAR PUBLIC
    // ===================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100|unique:produks,nama_produk',
            'harga' => 'required|numeric|min:1|max:500000',
            'stok' => 'required|integer|min:1|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

// Generate ID unik
$last = Produk::withTrashed()
    ->where('id_produk', 'like', 'PRD' . date('Ymd') . '%')
    ->orderByRaw("CAST(SUBSTRING(id_produk, 14, 5) AS UNSIGNED) DESC")
    ->first();

if ($last) {
    $lastNumber = intval(substr($last->id_produk, 13, 5));
    $newNumber = $lastNumber + 1;
} else {
    $newNumber = 1;
}

$id_produk = 'PRD' . date('Ymd') . '-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        // ✔ SIMPAN GAMBAR KE public/produk
        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $namaFile = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->move(public_path('produk'), $namaFile);
        }

        Produk::create([
            'id_produk' => $id_produk,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'id_kasir' => Auth::check() ? Auth::user()->id_kasir : 1,
            'gambar' => $namaFile,
        ]);

        return redirect()->route('produks.index')
            ->with('success', "Produk berhasil ditambahkan dengan ID $id_produk!");
    }


    // ===================================================
    // UPDATE PRODUK — FIX UPDATE GAMBAR PUBLIC
    // ===================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100|unique:produks,nama_produk,' . $id . ',id_produk',
            'harga' => 'required|numeric|min:1|max:500000',
            'stok' => 'required|integer|min:1|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = Produk::findOrFail($id);

        // ✔ JIKA GANTI GAMBAR
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(public_path('produk/' . $produk->gambar))) {
                unlink(public_path('produk/' . $produk->gambar));
            }

            $namaFile = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->move(public_path('produk'), $namaFile);
            $produk->gambar = $namaFile;
        }

        // Update field lain
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->save();

        return redirect()->route('produks.index')->with('success', 'Produk berhasil diperbarui!');
    }


    // ===================================================
    // DELETE PRODUK — HAPUS FILE JUGA
    // ===================================================
public function destroy($id_produk)
{
    $produk = Produk::where('id_produk', $id_produk)->firstOrFail();

    // Null-in nama supaya tidak bentrok dengan unique
    $produk->nama_produk = null;
    
    // Kolom lain TIDAK diubah
    // harga tetap
    // stok tetap
    // id_kasir tetap
    // dll tetap sama

    $produk->save();

    // Soft delete
    $produk->delete();

    return redirect()->route('produks.index')
        ->with('success', 'Produk berhasil dihapus!');
}


}
