@extends('layout.app')

@section('content')
<style>
/* === STYLE KHUSUS DASHBOARD === */
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

.dashboard-content {
    margin-left: 230px;
    margin-top: 90px;
    padding: 30px 60px;
    background-color: #f9f9f9;
    min-height: 100vh;
}

.stat-boxes {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 25px;
    margin-bottom: 50px;
}

.stat-box {
    flex: 0 0 30%;
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    text-align: center;
    border: 1px solid #ddd;
    position: relative;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

.stat-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 10px;
    height: 100%;
    background-color: #3B2817;
    border-radius: 10px 0 0 10px;
}

.stat-box h3 {
    font-weight: 500;
    color: #2c2c2c;
    margin-bottom: 10px;
}

.stat-box p {
    font-size: 22px;
    font-weight: 600;
    color: #3B2817;
}

.chart-section {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 40px;
}

.chart-container {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 20px;
    width: 45%;
    height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

.chart-title {
    text-align: center;
    font-weight: 600;
    margin-bottom: 15px;
    color: #3B2817;
}
</style>

<!-- Header Dashboard -->
<div class="dashboard-header">DASHBOARD</div>

<!-- Isi Dashboard -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card shadow-sm text-center p-3" style="border-left: 5px solid #C9A646;">
      <h6>Total Produk</h6>
      <h3>{{ $totalProduk ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm text-center p-3" style="border-left: 5px solid #C9A646;">
      <h6>Transaksi Hari Ini</h6>
      <h3>{{ $transaksiHariIni ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm text-center p-3" style="border-left: 5px solid #C9A646;">
      <h6>Menunggu Konfirmasi</h6>
      <h3>{{ $menungguKonfirmasi ?? 0 }}</h3>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card shadow-sm text-center p-3" style="border-left: 5px solid #C9A646;">
      <h6>Total Pendapatan</h6>
      <h3>Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
    </div>
  </div>
</div>

<hr class="mb-4">

<div class="row">
  <div class="col-md-6">
    <div class="card shadow-sm p-3 d-flex flex-column justify-content-center align-items-center" style="height: 370px;">
      <h5 class="text-center mb-3 text-dark">Penjualan Harian</h5>
      <canvas id="salesChart" style="height: 270px !important;"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card shadow-sm p-3 d-flex flex-column justify-content-center align-items-center" style="height: 370px;">
      <h5 class="text-center mb-3 text-dark">Metode Pembayaran</h5>
      <canvas id="paymentChart" style="height: 270px !important;"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx1 = document.getElementById('salesChart');
new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
    datasets: [{
      label: 'Jumlah Transaksi',
      data: [5, 8, 10, 6, 12, 9, 11],
      backgroundColor: '#C9A646',
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: { beginAtZero: true }
    }
  }
});

const ctx2 = document.getElementById('paymentChart');
new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Tunai', 'Transfer'],
    datasets: [{
      data: [60, 40],
      backgroundColor: ['#C9A646', '#3E2C1C'],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '70%',
    plugins: {
      legend: {
        position: 'bottom',
        labels: { boxWidth: 15, color: '#3E2C1C' }
      }
    }
  }
});
</script>
@endsection
