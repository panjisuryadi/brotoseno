<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Emas</title>
    <style>
        * {
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }

        body {
            width: 80mm;
            margin: 0;
            padding: 0;
        }

        .receipt {
            padding: 10px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .small {
            font-size: 10px;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt">
        <div class="title">Lovin Cahaya</div>
        <div class="center small">No Nota: {{$luar['nota']}}</div>
        <div class="center small">Tanggal: {{ date('d/m/Y H:i:s') }}</div>

        <div class="line"></div>

        <div><strong>Produk:</strong></div>
        <div>{{$luar['name']}}</div>
        <div>{{$luar['code']}}</div>
        <div>Berat: {{$luar['berat']}} gram</div>
        <div class="right">Rp {{number_format($luar['harga'])}}</div>

        <div class="line"></div>

        <table style="width: 100%;">
            <tr>
                <td><strong>Metode Pembayaran</strong></td>
                <td class="right">Cash</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td class="right"><strong>Rp {{number_format($luar['harga'])}}</strong></td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="center small">Terima kasih </div>
    </div>
</body>
</html>
