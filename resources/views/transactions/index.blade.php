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
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
               @forelse ($produks as $index => $produk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td>
                        <a href="{{ route('produk.edit', $produk->id_produk) }}">
                            <button class="btn-edit"><i class="fa-solid fa-pen"></i> Edit</button>
                        </a>
                        <form action="{{ route('produk.destroy', $produk->id_produk) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete" onclick="return confirm('Yakin mau hapus produk ini?')">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="no-data">Belum ada produk terdaftar</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<STyle>
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
.table-section {
    margin-top: 30px;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
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

.btn-add {
    background-color: #C9A646;
    color: #fff;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.3s;
}

.btn-edit {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-edit:hover {
        background-color: #218838;
    }


        .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-delete:hover {
        background-color: #b02a37;
    }

.btn-add:hover {
    background-color: #b7963d;
}

/* Tabel styling */
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

.nodata {
    text-align: center;
    color: #777;
    padding: 20px;
}
</STyle>
@endsection
