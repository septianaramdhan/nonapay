<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf; // untuk cetak PDF kalau kamu mau nanti

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::latest()->get();
        return view('receipts.index', compact('receipts'));
    }

    public function print($id)
    {
        $receipt = Receipt::findOrFail($id);
        $transaction = Transaction::find($receipt->transaction_id);

        // kalau mau tampil langsung halaman cetak biasa:
        return view('receipts.print', compact('receipt', 'transaction'));

        // kalau mau auto download PDF tinggal aktifin ini 👇
        // $pdf = Pdf::loadView('receipts.print', compact('receipt', 'transaction'));
        // return $pdf->download('Struk_' . $receipt->receipt_code . '.pdf');
    }
}
