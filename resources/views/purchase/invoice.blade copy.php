<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; position: relative; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

        .signature p:last-child {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    @php
    $date   = date('d/m/Y');
    @endphp
    @foreach($products as $index => $product)
    <h2>{{ $product['title'] }}</h2>
    <p style="text-align: right; font-size:13px">{{ $date }}</p>
    {{ $product['customer'] }}
    
    <table style="font-size:14px">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Desc Produk</th>
                <th>Gram</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['desc'] }}</td>
                <td>{{ $product['gram'] }}</td>
                <td>Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Hormat Kami,</p>
        <p>____________</p>
    </div>

    {{-- Add page break except after last item --}}
    @if (!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
