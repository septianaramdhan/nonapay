@extends('layout.app')

@section('content')
<!-- Header Atas -->
<div style="background-color:#3E2C1C; padding:10px 30px; border-bottom:3px solid #C9A646;">
    <h2 style="color:#C9A646; font-family:'Poppins',sans-serif; font-weight:600; margin:0;">
        {{ $title ?? 'Dashboard' }}
    </h2>
</div>

<div class="container-fluid px-4 py-4">
    <!-- Kartu Ringkasan -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card summary-card">
                <div class="card-side"></div>
                <div class="card-body text-center">
                    <h5>Total Produk</h5>
                    <h2>{{ $totalProducts ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card summary-card">
                <div class="card-side"></div>
                <div class="card-body text-center">
                    <h5>Transaksi Hari Ini</h5>
                    <h2>{{ $todayTransactions ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card summary-card">
                <div class="card-side"></div>
                <div class="card-body text-center">
                    <h5>Total Pendapatan</h5>
                    <h2>Rp{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Grafik -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card chart-card">
                <div class="card-body">
                    <h5 class="chart-title">📊 Analitik Penjualan Mingguan</h5>
                    <canvas id="salesChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card chart-card">
                <div class="card-body">
                    <h5 class="chart-title">💰 Perbandingan Pembayaran</h5>
                    <canvas id="donutChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart: Analitik Penjualan
    const ctx1 = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: {!! json_encode($salesLabels ?? ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']) !!},
            datasets: [{
                label: 'Total Transaksi (Rp)',
                data: {!! json_encode($salesData ?? [120000,150000,90000,200000,180000,240000,130000]) !!},
                backgroundColor: '#C9A646',
                borderRadius: 6
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Donut Chart: Cash vs Transfer
    const ctx2 = document.getElementById('donutChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Cash', 'Transfer'],
            datasets: [{
                data: [{{ $cashTotal ?? 60 }}, {{ $transferTotal ?? 40 }}],
                backgroundColor: ['#C9A646', '#3E2C1C']
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<!-- Styling -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .summary-card {
        position: relative;
        border-radius: 10px;
        border: none;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        overflow: hidden;
        transition: transform .3s ease;
    }
    .summary-card:hover {
        transform: translateY(-3px);
    }
    .summary-card .card-side {
        position: absolute;
        left: 0;
        top: 0;
        width: 12px;
        height: 100%;
        background-color: #3E2C1C;
    }

    .chart-card {
        border-radius: 10px;
        border: 1.5px solid #3E2C1C;
        background-color: #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        padding: 10px 20px;
    }

    .chart-title {
        color: #C9A646;
        font-weight: 600;
        text-align: center;
        margin-bottom: 15px;
    }
</style>
@endsection
