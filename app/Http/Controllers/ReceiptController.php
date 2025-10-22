<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\Transaction;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::all();

        return view('receipts.index', [
            'title' => 'Cetak Struk',
            'receipts' => $receipts
        ]);
    }

    public function print($id)
    {
        $receipt = Receipt::findOrFail($id);
        $transaction = Transaction::find($receipt->transaction_id);

        return view('receipts.print', [
            'title' => 'Cetak Struk',
            'receipt' => $receipt,
            'transaction' => $transaction
        ]);
    }
}
