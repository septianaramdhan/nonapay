<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #000;
            width: 300px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 6px;
            margin-bottom: 6px;
        }

        .header .logo-title {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .header img {
            width: 40px;
            height: 40px;
        }

        .header strong {
            font-size: 16px;
        }

        .header small {
            font-size: 11px;
            display: block;
            line-height: 1.3;
        }

        .info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .total-section {
            font-size: 12px;
        }

        .total-section td {
            padding: 2px 0;
        }

        .thanks {
            text-align: center;
            margin-top: 10px;
            font-size: 11px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <div class="logo-title">
            <img src="{{ asset('nonapay-removebg-preview - Copy.png') }}" alt="Logo">
            <div>
                <strong>NONAPAY</strong>
                <small>
                    Jl. Sukamanah Cibolang RT 02 RW 08 Kec. Katapang Desa Sukamukti<br>
                    Kab. Bandung No.153<br>
                    Telp: 085772206459
                </small>
            </div>
        </div>
    </div>

    <div class="info">
        <span>{{ \Carbon\Carbon::parse($struk->tanggal_cetak)->format('d-m-Y H:i') }}</span>
        <span>No. Struk: {{ $struk->id_struk }}</span>
    </div>
    <div class="info">
        <span>{{ $transaksi->kasir ?? 'Kasir' }}</span>
        <span>{{ $transaksi->nama_kasir ?? '' }}</span>
    </div>

    <div class="line"></div>

    <table>
        @foreach ($detailTransaksis as $index => $detail)
        <tr>
            <td>{{ $index + 1 }}. {{ $detail->produk->nama_produk }}</td>
            <td style="text-align: right;">
                {{ $detail->jumlah }} x Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}
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
            <td style="text-align: right;">
                {{ ucfirst($transaksi->metode_pembayaran) }}
            </td>
        </tr>
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