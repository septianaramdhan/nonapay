@extends('layout.app')

@section('content')
<style>
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
</style>

<!-- Header -->
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
      <h6>Total Transaksi</h6>
      <h3>{{ $totalTransaksi ?? 0 }}</h3>
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
// === ambil data dari controller ===
const chartLabels = {!! $chartLabels !!};
const chartData = {!! $chartData !!};
const cash = {{ $cash }};
const transfer = {{ $transfer }};

// === BAR CHART PENJUALAN HARIAN ===
const ctx1 = document.getElementById('salesChart');
new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: chartLabels,
    datasets: [{
      label: 'Jumlah Transaksi',
      data: chartData,
      backgroundColor: '#C9A646',
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
        suggestedMax: 20, // batas tampilan default
        ticks: {
          callback: function(value) {
            // kalau data lebih besar dari 20, kasih tanda "+"
            return value >= 20 ? value + '+' : value;
          }
        }
      }
    }
  }
});

// === DONUT CHART METODE PEMBAYARAN ===
const ctx2 = document.getElementById('paymentChart');
new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Tunai', 'Transfer'],
    datasets: [{
      data: [cash, transfer],
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