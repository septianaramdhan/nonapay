@extends('layout.app')
@section('content')
<h3>Transaksi #{{ $transaction->id }}</h3>
<p>Tanggal: {{ $transaction->tanggal }}</p>
<p>Kasir: {{ $transaction->kasir->nama }}</p>
<table class="table"><thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead>
<tbody>
@foreach($transaction->details as $d)
<tr><td>{{ $d->product->nama }}</td><td>{{ $d->jumlah }}</td><td>{{ $d->harga_satuan }}</td><td>{{ $d->subtotal }}</td></tr>
@endforeach
</tbody></table>
<p>Total: {{ $transaction->total }}</p>
<p>Metode: {{ $transaction->metode_payment }}</p>
@if($transaction->metode_payment == 'Cash')
<p>Uang diterima: {{ $transaction->uang_diterima }}</p>
<p>Kembalian: {{ $transaction->kembalian }}</p>
@endif

<form method="POST" action="{{ route('transactions.confirm',$transaction->id) }}">
@csrf
@if($transaction->metode_payment === 'Transfer')
  <button class="btn btn-success">Konfirmasi Transfer (sudah diterima)</button>
@else
  <label>Uang diterima</label><input name="uang_diterima" class="form-control" required>
  <button class="btn btn-success mt-2">Konfirmasi Cash</button>
@endif
</form>

@if($transaction->receipt)
  <a href="#" onclick="window.print()" class="btn btn-secondary mt-2">Cetak Struk</a>
@endif
@endsection
