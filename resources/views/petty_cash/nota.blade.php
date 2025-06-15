<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            page-break-before: always;
        }
        .invoice {
            width: 100%;
            max-width: 900px;
            border: 1px solid #000;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            width: 100px;
        }
        .invoice-details, .total {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .invoice-details div, .total div {
            width: 45%;
        }
        .total {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .invoice-table th, .invoice-table td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .invoice-table th {
            background-color: #f2f2f2;
        }
        .invoice-table td {
            background-color: #fff;
        }
    </style>
</head>
<body>

    <div class="invoice">
        <div class="header">
            <img src="logo.png" alt="Logo"> <!-- Replace with your actual logo -->
            <h2>Toko Emas Cahaya</h2>
            <p>Ruko Sentra Gading Blok SG3 - No.6, Depan Pasar Modern Sinpasa, Gading Serpong Tangerang</p>
            <p>Telp: 021-54761931</p>
        </div>

        <div class="invoice-details">
            <div>
                <p><strong>Faktur No:</strong> 222536</p>
                <p><strong>Tanggal:</strong> 15 April 2025</p>
            </div>
            <div>
                <p><strong>Penerima:</strong> Aring F</p>
                <p><strong>Alamat:</strong> -</p>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Deskripsi</th>
                    <th>Berat</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Aring F</td>
                    <td>Aring L6</td>
                    <td>Gold 1 ml Ruth</td>
                    <td>0.98 g</td>
                    <td>Rp. 1.360.000</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <div><strong>Total:</strong></div>
            <div>Rp. 1.360.000</div>
        </div>

        <div class="footer">
            <p>Hormat Kami,</p>
            <p>Toko Emas Cahaya</p>
        </div>
    </div>

</body>
</html>
