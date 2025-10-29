<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    // halaman konfirmasi pembayaran
    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    // simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $product = Product::find($request->product_id);
        $totalPrice = $product->price * $request->quantity;

        // bikin kode transaksi otomatis (contoh: NP20251029-001)
        $code = 'NP' . Carbon::now()->format('Ymd') . '-' . Str::random(3);

        $transaction = Transaction::create([
            'code' => $code,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'created_at' => Carbon::now(),
        ]);

        // detail transaksi
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
        ]);

        // struk otomatis setelah transaksi
        Receipt::create([
            'transaction_id' => $transaction->id,
            'receipt_code' => 'RC-' . strtoupper(Str::random(6)),
            'total' => $totalPrice,
            'method' => $request->payment_method,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('receipts.index')->with('success', 'Transaksi berhasil disimpan!');
    }
}
