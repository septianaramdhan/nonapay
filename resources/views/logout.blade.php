@extends('layout.app')

@section('content')
<div class="dashboard-header">
    DASHBOARD
    <button id="btnLogout" class="btn-logout">Logout</button>
</div>

<div class="table-section">
    <h2>Selamat Datang di Dashboard</h2>
    <p>Isi konten dashboard di sini...</p>
</div>

<!-- Modal Logout -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <p>Yakin ingin keluar?</p>
        <div class="modal-buttons">
            <button id="confirmLogout" class="btn-confirm">Ya</button>
            <button id="cancelLogout" class="btn-cancel">Tidak</button>
        </div>
    </div>
</div>

<!-- Form Logout (POST) -->
<form id="logoutForm" method="POST" action="{{ route('logout') }}">
    @csrf
</form>

<style>
/* Dashboard header */
.dashboard-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: #3B2817;
    color: #C9A646;
    font-weight: 600;
    font-size: 26px;
    padding: 15px 40px;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Logout button */
.btn-logout {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}
.btn-logout:hover {
    background-color: #b02a37;
}

/* Table / content section */
.table-section {
    margin-top: 80px;
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    text-align: center;
    max-width: 400px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.modal-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-around;
}

.btn-confirm, .btn-cancel {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
}

.btn-confirm {
    background-color: #C9A646;
    color: #fff;
}

.btn-cancel {
    background-color: #dc3545;
    color: #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnLogout = document.getElementById('btnLogout');
    const modal = document.getElementById('logoutModal');
    const confirmBtn = document.getElementById('confirmLogout');
    const cancelBtn = document.getElementById('cancelLogout');
    const logoutForm = document.getElementById('logoutForm');

    // Tampilkan modal saat klik logout
    btnLogout.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    // Logout saat konfirmasi
    confirmBtn.addEventListener('click', () => {
        logoutForm.submit();
    });

    // Tutup modal saat batal
    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Tutup modal jika klik di luar
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
@endsection
