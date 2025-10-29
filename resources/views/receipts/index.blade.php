@extends('layout.app')
@section('content')
<div class="dashboard-header">CETAK STRUK</div>
<div class="container mt-4">
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>No Struk</th>
                <th>Kode Transaksi</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipts as $r)
            <tr>
                <td>{{ $r->receipt_code }}</td>
                <td>{{ $r->transaction->code ?? '-' }}</td>
                <td>{{ ucfirst($r->method) }}</td>
                <td>Rp{{ number_format($r->total, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('receipts.print', $r->id) }}" class="btn btn-sm btn-dark">🧾 Cetak</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<style>
.dashboard-header {
    position: fixed;
    top: 0;
    left: 230px; /* biar nempel sama sidebar */
    right: 0;
    background-color: #3B2817; /* coklat tua */
    color: #C9A646; /* emas */
    font-weight: 600;
    font-size: 26px;
    padding: 15px 40px;
    z-index: 1000;
    letter-spacing: 1px;
}
</style>
@endsection
