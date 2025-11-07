@extends('layout.app')
@section('content')
<div class="dashboard-header">TAMBAH TRANSAKSI</div>

<div class="table-section">
    <div class="table-header">
        <h4>Input Transaksi Baru</h4>
        <a href="{{ route('transactions.index') }}" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Lihat Data Transaksi</a>
    </div>

    <form action="{{ route('transactions.store') }}" method="POST" class="form-transaksi" id="transaksiForm">
        @csrf

        <div id="produk-container">
            <div class="produk-row">
                <div class="form-group">
                    <label>Produk</label>
                    <select name="id_produk[]" class="produk-select" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}">
                                {{ $produk->nama_produk }} - Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
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

        <div class="form-group">
            <label for="catatan">Catatan (opsional)</label>
            <input type="text" name="catatan" id="catatan" placeholder="Masukkan catatan jika ada">
        </div>

        <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
    </form>
</div>

<style>
/* ========== STYLING TETEP SAMA ========== */
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

    function hitungTotal() {
        let total = 0;
        container.querySelectorAll('.produk-row').forEach(row => {
            const select = row.querySelector('.produk-select');
            const jumlah = row.querySelector('.jumlah-input').value;
            const harga = select.selectedOptions[0]?.dataset.harga || 0;
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
            const uang = parseFloat(uangDiterima.value || 0);
            const hasil = uang - total;
            kembalian.value = hasil >= 0 ? 'Rp' + hasil.toLocaleString('id-ID') : 'Rp0';
        } else {
            kembalian.value = '';
        }
    }

    tambahBtn.addEventListener('click', () => {
        const row = container.querySelector('.produk-row').cloneNode(true);
        row.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(row);
    });

    window.hapusProduk = (btn) => {
        if (container.querySelectorAll('.produk-row').length > 1) {
            btn.closest('.produk-row').remove();
            hitungTotal();
        }
    };

    container.addEventListener('change', hitungTotal);
    container.addEventListener('input', hitungTotal);
    uangDiterima.addEventListener('input', hitungKembalian);

    metode.addEventListener('change', () => {
        if (metode.value === 'cash') {
            uangSection.style.display = 'block';
            uangDiterima.required = true;
        } else {
            uangSection.style.display = 'none';
            uangDiterima.required = false;
        }
        hitungKembalian();
    });

    // ✅ Validasi panjang digit realtime + di submit
    function cekPanjangDigit() {
        const uangStr = uangDiterima.value.trim();
        const bagianUtama = uangStr.split('.')[0].replace(/\D/g, '');
        if (bagianUtama.length > 12) {
            uangDiterima.setCustomValidity('Nominal uang diterima melebihi 12 digit! (max 12 digit sebelum koma)');
        } else {
            uangDiterima.setCustomValidity('');
        }
    }

    // Cek setiap kali input berubah
    uangDiterima.addEventListener('input', cekPanjangDigit);

    form.addEventListener('submit', (e) => {
        const total = parseInt(totalInput.value.replace(/\D/g, '')) || 0;

        cekPanjangDigit(); // pastikan dicek lagi sebelum submit
        if (!form.checkValidity()) {
            alert(uangDiterima.validationMessage);
            e.preventDefault();
            return;
        }

        if (metode.value === 'cash') {
            const uang = parseFloat(uangDiterima.value || 0);
            if (uang < total) {
                alert('Uang diterima kurang dari total transaksi!');
                e.preventDefault();
            }
        }
    });
});
</script>

@endsection
