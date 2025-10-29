<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Nonapay</title>
  <style>
    body { font-family: Arial, sans-serif; color:#333; }
    .header { text-align:center; }
    .detail { margin-top:20px; }
    .total { margin-top:10px; font-weight:bold; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Nonapay</h2>
    <p>Struk Pembayaran</p>
    <hr>
  </div>
  <div class="detail">
    <p><strong>No Struk:</strong> {{ $receipt->receipt_code }}</p>
    <p><strong>Kode Transaksi:</strong> {{ $transaction->code }}</p>
    <p><strong>Metode:</strong> {{ ucfirst($receipt->method) }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($receipt->total, 0, ',', '.') }}</p>
  </div>
  <div class="total">
    <p>Terima kasih telah bertransaksi di Nonapay ❤️</p>
  </div>
</body>
</html>
