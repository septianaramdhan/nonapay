<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        @page { size: 80mm auto; margin: 0; }
        body { font-family: 'Courier New', monospace; font-size: 13px; color: #000; width: 80mm; margin: 0 auto; padding: 5px; }
        .header { text-align: center; padding-bottom: 6px; margin-bottom: 6px; }
        .header img { width: 50px; height: 50px; margin-bottom: 5px; }
        .header small { font-size: 11px; display: block; line-height: 1.3; }
        .info { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 5px; }
        .line { border-top: 1px dashed #000; margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        table td { padding: 3px 0; vertical-align: top; }
        .total-section td { padding: 2px 0; }
        .thanks { text-align: center; margin-top: 10px; font-size: 11px; border-top: 1px dashed #000; padding-top: 5px; }
        @media print { body { margin: 0; padding: 0; width: 80mm; } }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <img src="{{ asset('nonapay-removebg-preview - Copy.png') }}" alt="Logo"style="width:120px; height:120px; margin-bottom:1px;">
        <small>
            Jl. Sukamanah Cibolang RT 02 RW 08 Kec. Katapang Desa Sukamukti<br>
            Kab. Bandung No.153<br>
            Telp: 085772206459
        </small>
    </div>

    <div class="line" style="margin:6px 0;"></div>

    <div class="info">
        <span>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y H:i') }}</span>
        <span>No. Struk: {{ $struk->id_struk }}</span>
    </div>
    <div class="info">
        <span>Kasir: {{ $transaksi->kasir->nama_kasir ?? 'Kasir' }}</span>
    </div>

    <div class="line"></div>

    <table>
        @foreach ($detailTransaksis as $index => $detail)
        <tr>
            <td>{{ $index + 1 }}. {{ $detail->produk->nama_produk }}</td>
            <td style="text-align: right;">
                {{ $detail->jumlah }} x Rp{{ number_format($detail->produk->harga, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table class="total-section">
        <tr>
            <td>Subtotal</td>
            <td style="text-align: right;">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td style="text-align: right;">0%</td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td style="text-align: right;"><strong>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="line"></div>

    <table class="total-section">
        <tr>
            <td>Metode Pembayaran</td>
            <td style="text-align: right;">{{ ucfirst($transaksi->metode_pembayaran) }}</td>
        </tr>

        @if ($transaksi->metode_pembayaran == 'transfer')
            @if ($transaksi->tipe_transfer == 'bank')
                <tr>
                    <td>Bank Tujuan</td>
                    <td style="text-align: right;">{{ $transaksi->nama_bank ?? '-' }}</td>
                </tr>
                <tr>
                    <td>No. Rekening</td>
                    <td style="text-align: right;">{{ $transaksi->nomor_rekening ?? '-' }}</td>
                </tr>
            @elseif ($transaksi->tipe_transfer == 'ewallet')
                <tr>
                    <td>Nama E-Wallet</td>
                    <td style="text-align: right;">{{ $transaksi->nama_ewallet ?? '-' }}</td>
                </tr>
                <tr>
                    <td>No. E-Wallet</td>
                    <td style="text-align: right;">{{ $transaksi->nomor_ewallet ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Atas Nama</td>
                    <td style="text-align: right;">{{ $transaksi->nama_pengirim ?? '-' }}</td>
                </tr>
            @endif
        @endif

        <tr>
            <td>Uang Diterima</td>
            <td style="text-align: right;">Rp{{ number_format($transaksi->uang_diterima, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembalian</td>
            <td style="text-align: right;">Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="thanks">
        Terimakasih sudah berbelanja di Nonapay, semoga berkah.
    </div>

</body>
</html>
