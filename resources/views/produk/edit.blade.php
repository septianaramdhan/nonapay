@extends('layout.app')

@section('content')
<style>

      .header-page content {
         margin-left: 230px;
    margin-top: 90px;
    padding: 30px 60px;
    background-color: #f9f9f9;
    min-height: 100vh;

    }
    .header-page {
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

    .form-section {
        flex-grow: 1;
        padding: 40px;
        background-color: #f9f6f2;
        min-height: 100vh;
    }

    .form-container {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        max-width: 700px;
        margin: 0 auto;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #3b2a1a;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .btn-submit {
        background-color: #b9935a;
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background-color: #a47e4b;
    }

    .btn-back {
        background-color: #3b2a1a;
        color: #f6d78d;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        margin-left: 10px;
        transition: 0.3s;
    }

    .btn-back:hover {
        background-color: #2d1f12;
    }
</style>

<div class="header-page">EDIT PRODUK</div>

<div class="form-section">
    <div class="form-container">
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf
            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" required>

            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" required>

            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" required>

            <button type="submit" class="btn-submit"><i class="fa-solid fa-plus"></i> Konfirmasi</button>
            <a href="{{ route('produk.index') }}"><button type="button" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</button></a>
        </form>
    </div>
</div>
@endsection