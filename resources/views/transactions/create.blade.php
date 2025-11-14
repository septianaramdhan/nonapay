@extends('layout.app')
@section('content')
<div class="dashboard-header">TAMBAH TRANSAKSI</div>

<div class="table-section">
    <div class="table-header">
        <h4>Input Transaksi Baru</h4>
        <a href="{{ route('transactions.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Lihat Data Transaksi
        </a>
    </div>

    <form action="{{ route('transactions.store') }}" method="POST" class="form-transaksi" id="transaksiForm">
        @csrf

        {{-- 🔍 CARI PRODUK --}}
        <div id="produk-container">
            <div class="produk-row">
                <div class="form-group">
                    <label>Produk</label>
                    <div class="search-wrapper">
                        <input type="text" class="produk-search" placeholder="Cari produk..." autocomplete="off">
                        <div class="produk-dropdown"></div>
                    </div>
                    <input type="hidden" name="id_produk[]" class="produk-id">
                </div>

                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah[]" class="jumlah-input" min="1" placeholder="Masukkan jumlah" required>
                </div>

                <div class="form-group">
                    <label>Subtotal</label>
                    <input type="text" class="subtotal" readonly>
                </div>

                <button type="button" class="btn-remove" onclick="hapusProduk(this)">Hapus</button>
            </div>
        </div>

        <button type="button" class="btn-tambah-produk" id="tambahProduk">+ Tambah Produk</button>

        <div class="form-group total-wrapper">
            <label>Total Harga</label>
            <input type="text" id="total_harga" name="total_harga" readonly>
        </div>

        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="">-- Pilih Metode --</option>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>

        {{-- Uang Diterima (Cash Only) --}}
        <div id="uangSection" style="display: none;">
            <div class="form-group">
                <label for="uang_diterima">Uang Diterima</label>
                <input type="number" name="uang_diterima" id="uang_diterima" placeholder="Masukkan jumlah uang">
            </div>

            <div class="form-group">
                <label>Kembalian</label>
                <input type="text" id="kembalian" readonly>
            </div>
        </div>

        {{-- Transfer Section --}}
        <div id="transferSection" style="display: none;">
            <div class="form-group">
                <label for="jenis_transfer">Jenis Transfer</label>
                <select name="jenis_transfer" id="jenis_transfer">
                    <option value="">-- Pilih Jenis Transfer --</option>
                    <optgroup label="Bank">
                        <option value="BCA">Bank BCA</option>
                        <option value="BNI">Bank BNI</option>
                        <option value="BRI">Bank BRI</option>
                        <option value="Mandiri">Bank Mandiri</option>
                    </optgroup>
                    <optgroup label="E-Wallet">
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO</option>
                        <option value="GoPay">GoPay</option>
                        <option value="ShopeePay">ShopeePay</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group" id="bankField" style="display: none;">
                <label for="no_rekening">Nomor Rekening</label>
                <input type="text" name="no_rekening" id="no_rekening" placeholder="Masukkan nomor rekening">
            </div>

           <div class="form-group" id="ewalletField" style="display: none;">
    <label for="atas_nama">Atas Nama (A/N)</label>
    <input type="text" name="atas_nama" id="atas_nama" placeholder="Masukkan nama pemilik akun">

    <label for="nomor_ewallet" style="margin-top:10px;">Nomor E-Wallet</label>
    <input type="text" name="no_ewallet" id="nomor_ewallet" placeholder="Masukkan nomor e-wallet">
</div>

        </div>

        <button type="submit" class="btn-submit">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi
        </button>
    </form>
</div>

<style>
/* ======== STYLE UTAMA ========= */
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
    max-width: 900px;
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

.btn-tambah-produk {
    background-color: #C9A646;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-tambah-produk:hover {
    background-color: #b38e39;
}

.produk-row {
    display: grid;
    grid-template-columns: 1fr 0.6fr 0.8fr auto;
    gap: 10px;
    align-items: end;
    margin-bottom: 10px;
}

.btn-remove {
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 8px 10px;
    cursor: pointer;
}

.btn-remove:hover {
    background-color: #b02a37;
}

.total-wrapper input {
    background-color: #f6f1e7;
    font-weight: bold;
}

#transferSection {
    background-color: #fdfaf4;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 10px;
    margin-top: 10px;
}

/* 🔍 STYLE CARI PRODUK */
.search-wrapper {
    position: relative;
}

.produk-search {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.produk-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ccc;
    border-radius: 0 0 8px 8px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 999;
    display: none;
}

.produk-dropdown div {
    padding: 8px 10px;
    cursor: pointer;
    transition: 0.2s;
}

.produk-dropdown div:hover {
    background-color: #f6f1e7;
     opacity: 1;
    transform: scale(1.1);
}

.produk-dropdown div i {
    opacity: 0.8;
    transition: 0.2s;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('produk-container');
    const tambahBtn = document.getElementById('tambahProduk');
    const metode = document.getElementById('metode_pembayaran');
    const uangSection = document.getElementById('uangSection');
    const uangDiterima = document.getElementById('uang_diterima');
    const kembalian = document.getElementById('kembalian');
    const totalInput = document.getElementById('total_harga');
    const form = document.getElementById('transaksiForm');
    const transferSection = document.getElementById('transferSection');
    const jenisTransfer = document.getElementById('jenis_transfer');
    const bankField = document.getElementById('bankField');
    const ewalletField = document.getElementById('ewalletField');

    // 🔍 Setup pencarian produk
 function setupSearch(row) {
    const search = row.querySelector('.produk-search');
    const dropdown = row.querySelector('.produk-dropdown');
    const hiddenId = row.querySelector('.produk-id');

    // Render hasil produk
    function renderDropdown(data) {
        dropdown.innerHTML = '';

        if (!data || data.length === 0) {
            const emptyMsg = document.createElement('div');
            emptyMsg.textContent = 'Produk tidak ditemukan';
            emptyMsg.style.color = '#999';
            emptyMsg.style.textAlign = 'center';
            emptyMsg.style.padding = '8px';
            dropdown.appendChild(emptyMsg);
            dropdown.style.display = 'block';
            return;
        }

        data.forEach(p => {
            const item = document.createElement('div');
            item.textContent = `${p.nama_produk} - Rp${parseInt(p.harga).toLocaleString('id-ID')}`;
            item.style.padding = '8px';
            item.style.cursor = 'pointer';

            item.addEventListener('click', () => {
                search.value = p.nama_produk;
                hiddenId.value = p.id_produk;
                search.dataset.harga = p.harga;
                dropdown.style.display = 'none';

                const jumlahInput = row.querySelector('.jumlah-input');
                jumlahInput.value = 1;

                const subtotalInput = row.querySelector('.subtotal');
                subtotalInput.value = 'Rp' + parseInt(p.harga).toLocaleString('id-ID');

                hitungTotal();
            });

            dropdown.appendChild(item);
        });

        dropdown.style.display = 'block';
    }

    // Ambil produk berdasarkan keyword
    function fetchProduk(keyword = '') {
        fetch(`/produk/search?q=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(data => {
                console.log('🔍 Data produk:', data); // buat cek di console
                renderDropdown(data);
            })
            .catch(err => console.error('Error ambil produk:', err));
    }

    // Ketika diketik → cari
    search.addEventListener('input', () => {
        const keyword = search.value.trim();
        fetchProduk(keyword);
    });

    // Saat fokus → tampil semua produk
    search.addEventListener('focus', () => {
        fetchProduk('');
    });

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', (e) => {
        if (!row.contains(e.target)) dropdown.style.display = 'none';
    });
}



    // 💰 Hitung total dan subtotal otomatis
    function hitungTotal() {
        let total = 0;
        container.querySelectorAll('.produk-row').forEach(row => {
            const search = row.querySelector('.produk-search');
            const jumlah = parseInt(row.querySelector('.jumlah-input').value || 0);
            const harga = parseInt(search.dataset.harga || 0);
            const subtotal = jumlah * harga;
            row.querySelector('.subtotal').value = subtotal ? 'Rp' + subtotal.toLocaleString('id-ID') : '';
            total += subtotal;
        });
        totalInput.value = 'Rp' + total.toLocaleString('id-ID');
        hitungKembalian();
    }

    function hitungKembalian() {
        if (metode.value === 'cash') {
            const total = parseInt(totalInput.value.replace(/\D/g, '')) || 0;
            const uang = parseInt(uangDiterima.value.replace(/\D/g,'') || 0);
            const hasil = uang - total;
            kembalian.value = hasil >= 0 ? 'Rp' + hasil.toLocaleString('id-ID') : 'Rp0';
        } else {
            kembalian.value = '';
        }
    }

    // ➕ Tambah produk baru
    tambahBtn.addEventListener('click', () => {
        const row = container.querySelector('.produk-row').cloneNode(true);
        row.querySelectorAll('input').forEach(el => el.value = '');
        row.querySelector('.produk-search').dataset.harga = '';
        container.appendChild(row);
        setupSearch(row);
    });

    // ❌ Hapus produk
    window.hapusProduk = (btn) => {
        if (container.querySelectorAll('.produk-row').length > 1) {
            btn.closest('.produk-row').remove();
            hitungTotal();
        }
    };

    container.addEventListener('input', hitungTotal);

    // ==========================
    // 💵 Uang diterima
    // ==========================

    // Awalnya sembunyikan
    uangSection.style.display = 'none';

metode.addEventListener('change', () => {
    if (metode.value === 'cash') {
        uangSection.style.display = 'block';
        transferSection.style.display = 'none';
    } else if (metode.value === 'transfer') {
        uangSection.style.display = 'none';
        transferSection.style.display = 'block';
    } else {
        uangSection.style.display = 'none';
        transferSection.style.display = 'none';
    }
});


    // Alert kalau lebih dari 12 digit
    uangDiterima.addEventListener('input', () => {
        let val = uangDiterima.value.replace(/\D/g,''); // ambil angka aja
        if (val.length > 7) {
            alert('Maksimal kasih uang 9,999,999!!');
            val = val.slice(0,7);
        }
        uangDiterima.value = val;
        hitungKembalian();
    });

    // ==========================
    // Transfer section
    // ==========================
    jenisTransfer.addEventListener('change', () => {
        const val = jenisTransfer.value;
        if (['BCA', 'BNI', 'BRI', 'Mandiri'].includes(val)) {
            bankField.style.display = 'block';
            ewalletField.style.display = 'none';
        } else if (['DANA', 'OVO', 'GoPay', 'ShopeePay'].includes(val)) {
            bankField.style.display = 'none';
            ewalletField.style.display = 'block';
        } else {
            bankField.style.display = 'none';
            ewalletField.style.display = 'none';
        }
    });

    // Submit form validasi
    form.addEventListener('submit', (e) => {
        const total = parseInt(totalInput.value.replace(/\D/g, '')) || 0;
        if (metode.value === 'cash') {
            const uang = parseInt(uangDiterima.value.replace(/\D/g,'') || 0);
            if (uang < total) {
                alert('Uang diterima kurang dari total transaksi!');
                e.preventDefault();
            }
        }
    });

    // 🔥 Inisialisasi pertama
    setupSearch(container.querySelector('.produk-row'));
});
</script>

@endsection
