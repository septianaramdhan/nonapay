<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', 'pending')->get();

        return view('payments.index', [
            'title' => 'Konfirmasi Pembayaran',
            'transactions' => $transactions
        ]);
    }

    public function confirm($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}
