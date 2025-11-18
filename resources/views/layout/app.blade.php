<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nonapay</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
    }

    .sidebar {
      width: 240px;
      height: 100vh;
      background-color: #3E2C1C;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .sidebar .logo {
      text-align: center;
      padding: 20px 0;
      border-bottom: 1px solid #5a402a;
    }

    .sidebar .logo img {
      width: 100px;
    }

    .sidebar .logo h4 {
      color: #C9A646;
      margin-top: 10px;
      font-weight: 700;
    }

    .sidebar .menu {
      padding: 20px;
      flex: 1;
    }

    .sidebar .menu a {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: white;
      margin-bottom: 14px;
      font-weight: 500;
      border-radius: 5px;
      padding: 8px 10px;
      transition: all 0.2s ease;
    }

    .sidebar .menu a i {
      font-size: 16px;
      width: 20px;
      text-align: center;
    }

    .sidebar .menu a.active,
    .sidebar .menu a:hover {
      background-color: #C9A646;
      color: #3E2C1C;
    }

    .sidebar .logout {
      text-align: center;
      padding: 15px;
      border-top: 1px solid #5a402a;
    }

    .sidebar .logout a {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .sidebar .logout a i {
      font-size: 16px;
    }

    .sidebar .logout a:hover {
      color: #C9A646;
    }

    .content {
      margin-left: 240px;
      padding: 25px;
      background-color: #f9f9f9;
      min-height: 100vh;
    }

    .page-title {
      font-size: 24px;
      color: #C9A646;
      background-color: #3E2C1C;
      padding: 10px 20px;
      border-radius: 6px;
      display: inline-block;
      font-weight: 600;
      margin-bottom: 25px;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <div>
      <div class="logo">
        <img src="{{ asset('nonapay-removebg-preview.png') }}" alt="Logo Nonapay">
      </div>

      <div class="menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-house"></i> Dashboard
        </a>
        <a href="{{ route('produks.index') }}" class="{{ request()->routeIs('produk.*') ? 'active' : '' }}">
  <i class="fa-solid fa-box"></i> Kelola Produk
</a>
<a href="{{ route('transactions.create') }}" class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
  <i class="fa-solid fa-credit-card"></i> Konfirmasi Pembayaran
</a>
<a href="{{ route('struk.index') }}" class="{{ request()->routeIs('struk.*') ? 'active' : '' }}">
  <i class="fa-solid fa-receipt"></i> Cetak Struk
</a>
      </div>
    </div>

    <div class="logout">
      <a href="{{ route('logout') }}">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </a>
    </div>
  </div>

  <div class="content">
    <h1 class="page-title">@yield('title')</h1>
    @yield('content')
  </div>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // Pop-up Logout
    document.addEventListener('DOMContentLoaded', function() {
      const logoutBtn = document.querySelector('.logout a');
      if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
          e.preventDefault();
          const url = this.getAttribute('href');

          Swal.fire({
            title: 'Anda akan keluar',
            text: 'Yakin mau keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#C9A646',
            cancelButtonColor: '#3E2C1C',
            confirmButtonText: 'Iya',
            cancelButtonText: 'Tidak'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = url;
            }
          });
        });
      }

      // Pop-up Notifikasi Transaksi
      @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#C9A646'
      });
      @endif

      @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Stok Tidak Cukup',
        text: '{{ session('error') }}',
        confirmButtonColor: '#3E2C1C'
      });
      @endif

       @if(session('errorl'))
      Swal.fire({
        icon: 'error',
        title: 'No & Nama tidak sesuai!',
        text: '{{ session('errorl') }}',
        confirmButtonColor: '#3E2C1C'
      });
      @endif
    });
  </script>

</body>
</html>
