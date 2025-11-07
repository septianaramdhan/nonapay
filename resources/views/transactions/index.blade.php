@extends('layout.app')
@section('content')
<div class="dashboard-header">KONFIRMASI PEMBAYARAN</div>

<div class="table-section">
    <div class="table-header">
        <h4>Data Transaksi</h4>
        <a href="{{ route('transactions.create') }}" class="btn-add">+ Tambah Transaksi</a>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Uang Diterima</th>
                <th>Kembalian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $index => $transaksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</td>
                    <td>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @if ($transaksi->metode_pembayaran == 'cash')
                            <span class="cash">Cash</span>
                        @else
                            <span class="transfer">Transfer</span>
                        @endif
                    </td>
                    <td>Rp{{ number_format($transaksi->uang_diterima, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('transactions.show', $transaksi->id_transaksi) }}" class="btn-detail">Lihat Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="no-data">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
.dashboard-header {
    position: fixed;
    top: 0;
    left: 230px;
    right: 0;
    background-color: #3B2817;
    color: #C9A646;
    font-weight: 600;
    font-size: 26px;
    padding: 15px 40px;
    z-index: 1000;
    letter-spacing: 1px;
}

.table-section {
    margin-top: 40px;
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.table-header h4 {
    color: #3B2817;
    font-weight: 600;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    color: #3B2817;
}

.btn-add {
    background-color: #C9A646;
    color: #fff;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-detail {
    background-color: #3B2817;
    color: #C9A646;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-detail:hover {
    opacity: 0.9;
}

.custom-table th {
    background-color: #3B2817;
    color: #C9A646;
    padding: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.custom-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.custom-table tr:hover {
    background-color: #f6f1e7;
}

.cash {
    color: green;
    font-weight: 600;
}

.transfer {
    color: #007bff;
    font-weight: 600;
}

.no-data {
    text-align: center;
    color: #777;
    padding: 20px;
}
</style>
@endsection