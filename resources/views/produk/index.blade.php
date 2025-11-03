@extends('layout.app')

@section('content')
<div class="dashboard-header">KELOLA PRODUK</div>

    <div class="table-section">
        <div class="table-header">
            <h4>Daftar Produk</h4>
            <a href="{{ route('produk.create') }}" class="btn-add">+ Tambah Produk</a>
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
                @forelse($produks as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <a href="{{ route('produk.edit', $product->id) }}" class="btn-edit">✏️</a>
                        <form action="{{ route('produk.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus produk ini?')">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-text">Belum ada produk yang ditambahkan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>

/* Header label */
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


/* Tabel */
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

.empty-text {
    text-align: center;
    color: #777;
    padding: 20px;
}

/* Tombol edit & hapus */
.btn-edit, .btn-delete {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 18px;
}

.btn-edit:hover {
    color: #C9A646;
}

.btn-delete:hover {
    color: #a3312f;
}
</style>
@endsection
