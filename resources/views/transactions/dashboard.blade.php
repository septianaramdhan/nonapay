@extends('layout.app')

@section('content')
<style>
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
</style>

<div class="dashboard-header">DASHBOARD</div>

<!-- 🔸 FILTER PERIODE -->
<div class="d-flex justify-content-end align-items-center mt-5 mb-3 me-4">
  <label for="filterPeriode" class="me-2 fw-semibold text-dark">Filter:</label>
  <select id="filterPeriode" class="form-select w-auto">
    <option value="harian" selected>Harian</option>
    <option value="mingguan">Mingguan</option>
    <option value="bulanan">Bulanan</option>
    <option value="custom">Custom</option>
  </select>
  <input type="date" id="customDate" class="form-control ms-2" style="width: 200px; display: none;">
  <button id="applyFilter" class="btn btn-dark ms-2" style="display: none;">Terapkan</button>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
  <div class="col-md-3"><div class="card shadow-sm text-center p-3" style="border-left:5px solid #C9A646;"><h6>Total Produk</h6><h3>{{ $totalProduk }}</h3></div></div>
  <div class="col-md-3"><div class="card shadow-sm text-center p-3" style="border-left:5px solid #C9A646;"><h6>Transaksi Hari Ini</h6><h3>{{ $transaksiHariIni }}</h3></div></div>
  <div class="col-md-3"><div class="card shadow-sm text-center p-3" style="border-left:5px solid #C9A646;"><h6>Total Transaksi</h6><h3>{{ $totalTransaksi }}</h3></div></div>
  <div class="col-md-3"><div class="card shadow-sm text-center p-3" style="border-left:5px solid #C9A646;"><h6>Total Pendapatan</h6><h3 id="pendapatanDisplay">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3></div></div>
</div>

<hr class="mb-4">

<div class="row">
  <div class="col-md-6">
    <div class="card shadow-sm p-3" style="height:370px;">
      <h5 id="chartTitle" class="text-center mb-3 text-dark">Penjualan (Harian)</h5>
      <canvas id="salesChart" style="height:270px !important;"></canvas>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card shadow-sm p-3" style="height:370px;">
      <h5 class="text-center mb-3 text-dark">Metode Pembayaran</h5>
      <canvas id="paymentChart" style="height:270px !important;"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const salesCtx = document.getElementById('salesChart');
const paymentCtx = document.getElementById('paymentChart');
const chartTitle = document.getElementById('chartTitle');
const filterSelect = document.getElementById('filterPeriode');
const customInput = document.getElementById('customDate');
const applyBtn = document.getElementById('applyFilter');
const pendapatanDisplay = document.getElementById('pendapatanDisplay');

// === INIT CHARTS ===
const salesChart = new Chart(salesCtx, {
    type: 'bar',
    data: { 
        labels: {!! $chartLabels !!}, 
        datasets: [{ 
            label: 'Jumlah Transaksi', 
            data: {!! $chartData !!}, 
            backgroundColor: '#C9A646', 
            borderRadius: 6 
        }] 
    },
    options: { 
        responsive:true, 
        maintainAspectRatio:false, 
        scales:{ y:{ beginAtZero:true, max:{{ $scaleY }} } } 
    }
});

const paymentChart = new Chart(paymentCtx, {
    type: 'doughnut',
    data: { 
        labels:['Tunai','Transfer'], 
        datasets:[{ data:[{{ $cash }}, {{ $transfer }}], backgroundColor:['#C9A646','#3E2C1C'] }] 
    },
    options:{ 
        responsive:true, 
        maintainAspectRatio:false, 
        cutout:'70%', 
        plugins:{ legend:{ position:'bottom' } } 
    }
});

// === FETCH DATA FUNCTION ===
function fetchChartData(periode, start='') {
    fetch(`/dashboard/filter?periode=${periode}&start=${start}`)
    .then(res => res.json())
    .then(data => {
        // update bar chart (sales)
        salesChart.data.labels = data.chartLabels;
        salesChart.data.datasets[0].data = data.chartData;

        let maxVal = Math.max(...data.chartData);
        if(periode==='harian') salesChart.options.scales.y.max = Math.max(maxVal,20);
        else if(periode==='mingguan') salesChart.options.scales.y.max = Math.max(maxVal,50);
        else if(periode==='bulanan') salesChart.options.scales.y.max = Math.max(maxVal,500);
        else salesChart.options.scales.y.max = Math.max(maxVal);
        salesChart.update();

        // 🟡 update donut chart & total pendapatan di semua filter
        paymentChart.data.datasets[0].data = [data.cash, data.transfer];
        paymentChart.update();

        pendapatanDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.totalPendapatan);
    })
    .catch(err => console.error('Error fetch data:', err));
}

// === FILTER HANDLER ===
filterSelect.addEventListener('change', () => {
    const isCustom = filterSelect.value==='custom';
    customInput.style.display = isCustom ? 'block':'none';
    applyBtn.style.display = isCustom ? 'inline-block':'none';

    let label = 'Penjualan ';
    if(filterSelect.value==='harian') label+='(Harian)';
    else if(filterSelect.value==='mingguan') label+='(Mingguan)';
    else if(filterSelect.value==='bulanan') label+='(Bulanan)';
    else label+='(Custom)';
    chartTitle.textContent = label;

    if(!isCustom) fetchChartData(filterSelect.value);
});

applyBtn.addEventListener('click', ()=>{
    const tanggal = customInput.value;
    if(!tanggal) return alert('Pilih tanggal dulu 😭');
    fetchChartData('custom', tanggal);
});
</script>
@endsection