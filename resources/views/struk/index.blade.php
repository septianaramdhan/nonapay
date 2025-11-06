@extends('layout.app')
@section('content')
<div class="dashboard-header">CETAK STRUK</div>
<div class="container mt-4">
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Struk</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($struks as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->id_struk }}</td>
                <td>{{ ucfirst($s->transaksi->metode_pembayaran ?? '-') }}</td>
                <td>Rp{{ number_format($s->transaksi->total_harga ?? 0, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('print', $s->id_struk) }}" class="btn btn-sm btn-dark">🧾 Cetak</a>
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
