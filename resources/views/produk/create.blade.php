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

<div class="header-page">TAMBAH PRODUK</div>

<div class="form-section">
    <div class="form-container">
        @if ($errors->any())
    <div style="background-color: #ffe6e6; color: #b30000; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('produk.store') }}" method="POST">
            @csrf
            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" required>

            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" required min="1" max="500000" maxlength="5">

            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" required min="1" max="1000" maxlength="4">

            <button type="submit" class="btn-submit"><i class="fa-solid fa-plus"></i> Simpan</button>
            <a href="{{ route('produk.index') }}"><button type="button" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</button></a>
        </form>
       <script>
document.addEventListener('DOMContentLoaded', () => {
    const hargaInput = document.getElementById('harga');
    const stokInput = document.getElementById('stok');

    hargaInput.setAttribute('maxlength', 5);
    stokInput.setAttribute('maxlength', 4);

    hargaInput.addEventListener('input', () => {
        let val = parseInt(hargaInput.value);
        if (val > 500000) {
            alert("😤 Ga realistis, dosa lho korupsi!");
            hargaInput.value = 500000;
        }
    });

    stokInput.addEventListener('input', () => {
        let val = parseInt(stokInput.value);
        if (val > 1000) {
            alert("😤 Mana punya modal segitu!");
            stokInput.value = 1000;
        }
    });
});
</script>
    </div>
</div>
@endsection