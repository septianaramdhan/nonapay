<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nonapay Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #3E2C1C;
            position: fixed;
            top: 0;
            left: 0;
            padding: 25px 20px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .logo-section {
            text-align: center;
        }

        .sidebar img {
            width: 80px;
            display: block;
            margin: 0 auto 10px auto;
        }

        .sidebar h4 {
            text-align: center;
            color: #C9A646;
            font-weight: bold;
            margin-bottom: 30px;
            font-size: 1.2rem;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #C9A646;
            color: #3E2C1C;
            font-weight: bold;
        }

        .sidebar .logout {
            color: #C9A646;
            font-weight: bold;
        }

        /* Content area */
        .content {
            margin-left: 260px;
            padding: 40px;
        }

        .content h1 {
            font-weight: 700;
            color: #3E2C1C;
        }

        /* Card styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            color: #3E2C1C;
            font-weight: 600;
        }

        .highlight {
            color: #C9A646;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .content {
                margin-left: 220px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div>
            <div class="logo-section">
                <img src="{{ asset('nonapay-removebg-preview.png') }}" alt="Logo Nonapay">
                <h4>Nonapay</h4>
            </div>

            <div class="menu">
                <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
                <a href="{{ route('index') }}">📦 Kelola Produk</a>
                <a href="{{ route('create') }}">💳 Konfirmasi Pembayaran</a>
                <a href="{{ route('show') }}">🧾 Cetak Struk</a>
            </div>
        </div>

        <div>
            <a href="{{ route('logout') }}" class="logout">🚪 Logout</a>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>
