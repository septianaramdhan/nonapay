@extends('layout.app')

@section('content')
<style>
   .header-page-content {
        margin-left: 230px;
        margin-top: 90px;
        padding: 30px 60px;
        background-color: #f9f9f9;
        min-height: 100vh;
    }

    .header-page {
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

        <form action="{{ route('produks.update', $produk->id_produk) }}" 
              method="POST" 
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <label for="nama_produk">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" 
                value="{{ old('nama_produk', $produk->nama_produk) }}" required>

            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" 
                value="{{ old('harga', $produk->harga) }}" required min="1" max="500000">

            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" 
                value="{{ old('stok', $produk->stok) }}" required min="1" max="1000">

            <label for="gambar">Gambar Produk (opsional)</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" onchange="previewEditGambar(this)">

            {{-- GAMBAR SAAT INI --}}
            <div style="margin-bottom: 20px;">
                @if($produk->gambar)
                    <img src="{{ asset('produk/' . $produk->gambar) }}" 
                         id="currentImage"
                         style="width:120px; margin-top:10px; border:1px solid #ddd;">
                @endif

                <img id="previewEdit" style="width: 120px; margin-top:10px; display:none;">
            </div>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-check"></i> Simpan Perubahan
                </button>

                <a href="{{ route('produks.index') }}">
                    <button type="button" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </button>
                </a>
            </div>

        </form>

        <script>
        function previewEditGambar(input) {
            let preview = document.getElementById('previewEdit');
            let current = document.getElementById('currentImage');

            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';

            if (current) current.style.display = 'none';
        }
        </script>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hargaInput = document.getElementById('harga');
            const stokInput = document.getElementById('stok');

            hargaInput.addEventListener('input', () => {
                if (hargaInput.value > 500000) {
                    alert("Max Harga 500.000!");
                    hargaInput.value = 500000;
                }
            });

            stokInput.addEventListener('input', () => {
                if (stokInput.value > 1000) {
                    alert("Max Stok 1000!");
                    stokInput.value = 1000;
                }
            });
        });
        </script>

    </div>
</div>

@endsection
