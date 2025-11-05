@extends('layout.app')
@section('content')
<div class="dashboard-header">TAMBAH TRANSAKSI</div>

<div class="table-section">
    <div class="table-header">
        <h4>Input Transaksi Baru</h4>
        <a href="{{ route('transactions.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <form action="{{ route('transactions.store') }}" method="POST" class="form-transaksi">
        @csrf
        <div class="form-group">
            <label for="id_produk">Produk</label>
            <select name="id_produk" id="id_produk" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($produks as $produk)
                    <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }} - Rp{{ number_format($produk->harga, 0, ',', '.') }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" min="1" placeholder="Masukkan jumlah beli" required>
        </div>

        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="">-- Pilih Metode --</option>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>

        <div class="form-group">
            <label for="uang_diterima">Uang Diterima (jika Cash)</label>
            <input type="number" name="uang_diterima" id="uang_diterima" placeholder="Masukkan jumlah uang">
        </div>

        <div class="form-group">
            <label for="catatan">Catatan (opsional)</label>
            <input type="text" name="catatan" id="catatan" placeholder="Masukkan catatan jika ada">
        </div>

        <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
    </form>
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
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
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

.form-transaksi .form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: 600;
    color: #3B2817;
    margin-bottom: 6px;
}

input[type="number"],
input[type="text"],
select {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.btn-submit {
    background-color: #C9A646;
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    transition: 0.3s;
}

.btn-submit:hover {
    background-color: #b38e39;
}

.btn-back {
    background-color: #3B2817;
    color: #C9A646;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-back:hover {
    background-color: #2a1c0f;
}
</style>
@endsection