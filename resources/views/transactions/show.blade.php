@extends('layout.app')

@section('content')
<div class="dashboard-header">DETAIL TRANSAKSI</div>

<div class="detail-container">
    <div class="detail-header">
        <h4>Detail Transaksi</h4>
        <a href="{{ route('transactions.index') }}" class="btn-back">← Kembali</a>
    </div>

    <div class="detail-info">
        <p><strong>ID Transaksi:</strong> {{ $transaksi->kode_transaksi ?? 'TRX-' . $transaksi->id_transaksi }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y, H:i') }}</p>
        <p><strong>Metode Pembayaran:</strong> 
            @if ($transaksi->metode_pembayaran == 'cash')
                <span class="cash">Cash</span>
            @else
                <span class="transfer">Transfer</span>
            @endif
        </p>
        <p><strong>Total Harga:</strong> Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        <p><strong>Uang Diterima:</strong> Rp{{ number_format($transaksi->uang_diterima, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
    </div>

    <h4 class="table-title">Detail Produk</h4>
<table class="custom-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga Satuan</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($detailTransaksis as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                <td>Rp{{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="no-data">Tidak ada detail transaksi.</td>
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
.detail-container {
    margin-top: 40px;
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}
.btn-back {
    background-color: #3B2817;
    color: #C9A646;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 8px;
    text-decoration: none;
}
.table-title {
    color: #3B2817;
    font-weight: 600;
    margin-bottom: 10px;
}
.custom-table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    color: #3B2817;
}
.custom-table th {
    background-color: #3B2817;
    color: #C9A646;
    padding: 12px;
    font-weight: 600;
}
.custom-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
.custom-table tr:hover {
    background-color: #f6f1e7;
}
.cash { color: green; font-weight: 600; }
.transfer { color: #007bff; font-weight: 600; }
</style>
@endsection
