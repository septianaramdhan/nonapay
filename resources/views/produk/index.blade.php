    @extends('layout.app')
    @section('content')
    <div class="dashboard-header">KELOLA PRODUK</div>
    <div class="table-section">
            <div class="table-header">
                <h4>Data Produk</h4>
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
                @forelse ($produks as $index => $produk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>@if ($produk->stok == 0) 
                                <span style ="color: red; font-weight: bold;"> {{ $produk->stok }} <span style="font-size: 13px; font-weight: bold;">(Stok habis!)</span> </span> 
                                    @elseif ($produk->stok <= 15) 
                                <span style ="color: orange; font-weight: bold;"> {{ $produk->stok }} <span style="font-size: 13px; font-weight: bold;">(Stok akan habis!)</span> </span> 
                                    @else 
                                    {{ $produk->stok }} @endif</td>
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
                            <button type="button" class="btn-view" 
                                onclick="openModal(
                                '{{ $produk->id_produk }}',
                                '{{ $produk->nama_produk }}',
                                '{{ number_format($produk->harga, 0, ',', '.') }}',
                                '{{ $produk->stok }}',
                                '{{ $produk->gambar ?? '' }}'
                                )">
                                &#8230; Lihat
                                    </button>


                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="no-data">Belum ada produk terdaftar</td></tr>
                @endforelse
                </tbody>
            </table>
            <!-- Modal Detail Produk -->
<div id="detailModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>Detail Produk</h3>

        <p><strong>ID Produk:</strong> <span id="m-id"></span></p>
        <p><strong>Nama Produk:</strong> <span id="m-nama"></span></p>
        <p><strong>Harga:</strong> Rp<span id="m-harga"></span></p>
        <p><strong>Stok:</strong> <span id="m-stok"></span></p>

        <p><strong>Gambar:</strong></p>

        <!-- GAMBAR PRODUK -->
        <img id="m-gambar" 
             src="" 
             alt="Gambar Produk" 
             style="max-width:200px; display:none; border-radius:8px;">

        <!-- JIKA GA ADA GAMBAR -->
        <p id="no-gambar" style="display:none; color:#888;">Tidak ada gambar</p>

        <!-- TOMBOL TUTUP -->
        <div style="text-align: right; margin-top: 20px;">
            <button onclick="closeModal()" class="modal-close">Tutup</button>
        </div>

    </div>
</div>

    </div>

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

    .btn-view {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-view:hover {
        background-color: #5a6268;
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

    /* Background gelap belakang modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0 !important;   /* penting */
        width: 100vw !important;
        height: 100vh !important;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000; /* lebih tinggi dari header */
    }



    /* Kotak modal */
    .modal-box {
        background: white;
        padding: 25px;
        border-radius: 12px;
        width: 420px;
        max-width: 90vw;
    }

    .modal-close {
        background: #C9A646;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        display: inline-block;
        width: auto !important;   /* biar tidak melebar sendiri */
    }

    .modal-close::after {
        content: none !important;  /* Hapus icon X bawaan template */
    }

    /* Tombol tutup warna coklat tua */
    .btn-close {
        background-color: #3B2817;
        color: #fff;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-close:hover {
        background-color: #2c1e12;
    }



    </STyle>
    <script>
    const baseUrl = "{{ asset('storage/produk') }}/";
</script>
    <script>
    function openModal(id, nama, harga, stok, gambar) {
        document.getElementById('m-id').innerText = id;
        document.getElementById('m-nama').innerText = nama;
        document.getElementById('m-harga').innerText = harga;
        document.getElementById('m-stok').innerText = stok;

        const img = document.getElementById('m-gambar');
        const noImg = document.getElementById('no-gambar');

        if (gambar && gambar !== '') {
            img.src = baseUrl + gambar;
            img.style.display = 'block';
            noImg.style.display = 'none';
        } else {
            img.style.display = 'none';
            noImg.style.display = 'block';
        }

        document.getElementById('detailModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }
    </script>


    @endsection
