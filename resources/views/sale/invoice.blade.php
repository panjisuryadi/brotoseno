<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        @page {
            size: A5 landscape; /* A5 paper size in landscape orientation */
            margin: 10mm; /* Small margin for the page */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            box-sizing: border-box;
        }

        .invoice {
            width: 100%;
            max-width: 100%;
            /* padding: 15px; */
            background-color: #f9f9f9;
            box-sizing: border-box;
            margin: 0 auto; /* Center the invoice */
        }

        .header {
            display: flex;
            justify-content: space-between; /* Ensure the logo and title are spaced apart */
            align-items: center;
            margin-bottom: 7px;
            font-size: 13px;
        }

        .header img {
            width: 70px; /* Adjust logo size */
        }

        .header h2 {
            flex-grow: 1;
            text-align: center; /* Center the title */
            margin: 0;
        }

        .header p {
            text-align: center;
        }


        
        .header {
            text-align: center; /* Center the content */
            width: 100%;
        }

        .header img {
            display: inline-block; /* Display image inline */
            width: 80px; /* Set the logo size */
            vertical-align: middle; /* Align the logo vertically */
            margin-right: 10px; /* Space between the logo and text */
        }

        .header div {
            display: inline-block; /* Display the text inline */
            vertical-align: middle; /* Align the text vertically */
            text-align: left; /* Align text to the left */
        }

        .header h2, .header p {
            margin: 0;
        }



        /* .invoice-details {
            width: 100%;
            margin-top: 10px;
            font-size: 12px;
            table-layout: fixed;
        }

        .invoice-details td {
            padding: 5px 10px;
            word-wrap: break-word;
        }

        .invoice-details .left {
            width: 50%;
            text-align: left;
        }

        .invoice-details .right {
            width: 50%;
            text-align: right;
        } */


        .summary-footer-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start; /* align items at top */
    margin-top: 20px;
    gap: 20px;
    page-break-inside: avoid; /* prevent breaking inside when printing */
}

.footer-text {
    flex: 1;
    font-size: 11px;
    line-height: 1.2;
}

.total-section {
    flex: 1;
    text-align: right;
    font-size: 11px;
    line-height: 1.2;
}

.summary-footer-container p {
    margin: 0 0 4px 0; /* reduce paragraph vertical margin */
}

.total-section div {
    margin-bottom: 2px; /* reduce space between totals */
}



        /* Align Total to the right */
        /* .total {
            margin-top: 10px;
            margin-right: 30px;
            font-size: 12px;
            font-weight: bold;
            text-align: right;
        } */

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .invoice-table th, .invoice-table td {
            padding: 6px 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 11px;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-table td {
            background-color: #fff;
        }

        /* .footer p {
            margin-top: 6px;
            font-size: 11px;
        }

        .footer p:last-child {
            margin-top: 8px;
        } */

        .page-break {
            page-break-after: always;
        }

        .invoice-details {
            width: 100%;
            margin-top: 7px;
            font-size: 11px;
            table-layout: fixed;
        }

        .invoice-details .left {
            width: 50%;
            text-align: left;
        }

        .invoice-details .right {
            width: 50%;
            text-align: right;
        }
       
    </style>
</head>

<body>
    @php
    $date = date('d M Y');
    $imagePath = public_path('storage/uploads/logo.png'); // Path to your image
    $imageData = base64_encode(file_get_contents($imagePath));
    $imageSrc = 'data:image/png;base64,' . $imageData;
    @endphp
    @foreach($products as $index => $product)

        @php
        $gambar = '1742774180.png';
        $gambar = $product['img'];
        if($gambar == 'non'){}

        else{
            $ipath = public_path('storage/uploads/'.$gambar); // Path to your image
            $idata = base64_encode(file_get_contents($ipath));
            $isrc = 'data:image/png;base64,' . $idata;
        }
        @endphp
    <div class="invoice">
        <div class="header">
            <!-- Left side: Logo -->
            <img src="{{ $imageSrc }}" alt="Logo">
            
            <!-- Centered: Toko Emas Cahaya -->
            <h3>Toko Emas Cahaya {{ $product['print'] }}</h3>
            <p>{{ $product['alamat'] }}</p>
            <p>{{ $product['telp'] }}</p>
        </div>

        <!-- <div class="row">
            <div class="col-6">
                <p>Hormat</p>
                <p>Toko</p>
            </div>
            <div class="col-2"><p></p><p></p><p></p></div>
            <div class="col-2"><p>total: Rp</p><p>Ongkos: Rp</p><p>Grand: Rp</p></div>
            <div class="col-2"><p> 4.510.000</p><p> 150.000</p><p> 4.660.000</p></div>
        </div> -->

        <!-- Invoice Details table -->
        <table class="invoice-details">
            <tr>
                <td class="left"><strong>No:</strong> {{ $product['sales_id'] }}</td>
                <td class="right"><strong>Tanggal:</strong> {{ $date }}</td>
            </tr>
            <tr>
                <td class="left"><strong>Penerima:</strong> {{ $product['customer'] }}</td>
                <td class="right"><strong>Alamat:</strong> {{ $product['address'] }}</td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
                <tr>
                @if ($product['title'] == 'Faktur')
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Berat</th>
                    <th>Harga</th>
                @else
                    <th>Pic</th>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Berat</th>
                    <th>Harga</th>
                @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                @if ($product['title'] == 'Faktur')
                    <td>{{ $product['desc'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['gram'] }}</td>
                    <td>Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>
                @else
                    <td><img src="{{ $isrc }}" style="width: 65px;" alt="Image"></td>
                    <td>{{ $product['desc'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['gram'] }}</td>
                    <td>Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>
                @endif
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <!-- Left cell: Footer text -->
                <td style="width: 50%; vertical-align: top; font-size: 11px; padding-right: 10px;">
                    <p style="margin: 0;">Hormat Kami,</p>
                    <p style="margin: 0;">Toko Emas Cahaya</p>
                </td>
                <!-- Right cell: Totals -->
                <td style="width: 50%; vertical-align: top; font-size: 11px; text-align: right; padding-left: 10px;">
                    <p style="margin: 0;"><strong>Harga:</strong> Rp {{ number_format($product['harga']+$product['diskon']-$product['ongkos'], 0, ',', '.') }}</p>
                    <p style="margin: 0;"><strong>Diskon:</strong> Rp {{ number_format($product['diskon'], 0, ',', '.') }}</p>
                    <p style="margin: 0;"><strong>Ongkos:</strong> Rp {{ number_format($product['ongkos'], 0, ',', '.') }}</p>
                    <p style="margin: 0;"><strong>Grand Total:</strong> Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                </td>
            </tr>
            
        </table>

        <p style="font-size:12px;"><u>{{$product['info']}}</u></p>
        <!-- <div class="summary-footer-container">
            <div class="footer-text">
                <p>Hormat Kami,</p>
                <p>Toko Emas Cahaya</p>
            </div>

            <div class="total-section">
                <div><strong>Total: </strong> Rp {{ number_format($product['harga'] - $product['ongkos'], 0, ',', '.') }}</div>
                <div><strong>Ongkos: </strong> Rp {{ number_format($product['ongkos'], 0, ',', '.') }}</div>
                <div><strong>Grand Total: </strong> Rp {{ number_format($product['harga'], 0, ',', '.') }}</div>
            </div>
        </div> -->

    </div>

    {{-- Add page break except after last item --}}
    @if (!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
