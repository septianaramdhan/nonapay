@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="header">EDIT PRODUK</h3>

    <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" class="produk-form">
        @csrf
        @method('PUT')

        <input type="text" name="id_produk" value="{{ $produk->id_produk }}" placeholder="id produk" readonly>
        <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" placeholder="nama produk" required>
        <input type="number" name="harga" value="{{ $produk->harga }}" placeholder="harga" required>
        <input type="number" name="stok" value="{{ $produk->stok }}" placeholder="stok" required>

        <button type="submit" class="btn-konfirmasi">KONFIRMASI</button>
    </form>
</div>

<style>
.container {
    max-width: 600px;
    margin: 50px auto;
    font-family: "Poppins", sans-serif;
}
.header {
    background-color: #3b2815;
    color: white;
    padding: 10px 15px;
    font-weight: 600;
    letter-spacing: 1px;
}
.produk-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 20px;
}
.produk-form input {
    border: 1px solid #7a6b56;
    padding: 10px;
    font-size: 14px;
    outline: none;
}
.btn-konfirmasi {
    align-self: flex-end;
    background-color: #c79a35;
    color: white;
    font-weight: 600;
    border: none;
    padding: 8px 15px;
    cursor: pointer;
}
.btn-konfirmasi:hover {
    background-color: #b1852c;
}
</style>
@endsection
