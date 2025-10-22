@extends('layout.app')

@section('content')
<div class="container mt-4">
  <h2>Daftar Struk Transaksi</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Metode</th>
        <th>Kembalian</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($transactions as $trx)
      <tr>
        <td>{{ $trx->id }}</td>
        <td>{{ $trx->product->name }}</td>
        <td>{{ $trx->quantity }}</td>
        <td>Rp{{ number_format($trx->total_price) }}</td>
        <td>{{ ucfirst($trx->payment_method) }}</td>
        <td>Rp{{ number_format($trx->change) }}</td>
        <td>
          <a href="{{ route('receipts.print', $trx->id) }}" class="btn btn-primary btn-sm">Cetak Struk</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
