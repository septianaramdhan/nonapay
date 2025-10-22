@extends('layout.app')

@section('content')
<div class="container mt-4">
  <h2>Konfirmasi Pembayaran</h2>

  <form action="{{ route('transactions.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="product_id" class="form-label">Pilih Produk</label>
      <select class="form-control" name="product_id" required>
        <option value="">-- Pilih Produk --</option>
        @foreach($products as $product)
          <option value="{{ $product->id }}">{{ $product->name }} - Rp{{ number_format($product->price) }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="quantity" class="form-label">Jumlah</label>
      <input type="number" class="form-control" name="quantity" min="1" required>
    </div>

    <div class="mb-3">
      <label for="payment_method" class="form-label">Metode Pembayaran</label>
      <select class="form-control" name="payment_method" id="payment_method" required>
        <option value="cash">Tunai</option>
        <option value="transfer">Transfer</option>
      </select>
    </div>

    <div class="mb-3" id="cash_input" style="display:none;">
      <label for="money_received" class="form-label">Uang Diterima</label>
      <input type="number" class="form-control" name="money_received">
    </div>

    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
  </form>
</div>

<script>
  const paymentSelect = document.getElementById('payment_method');
  const cashInput = document.getElementById('cash_input');

  paymentSelect.addEventListener('change', function() {
    cashInput.style.display = this.value === 'cash' ? 'block' : 'none';
  });
</script>
@endsection
