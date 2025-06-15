<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ $filename }}</title>
    <link rel="stylesheet" href="{{ public_path('b3/modern.normalize.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('b3/tailwindcss.min.css') }}">
    <style type="text/css">
        .header {
            text-align: center;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Memberikan tinggi sebesar viewport height untuk membuatnya vertikal di tengah */
            margin-bottom: 20px;
        }

        .img-container {
            position: absolute;
            top: 0;
            left: 41%;
            align-items: center;
            max-width: 200px;
        }

        .img {
            width: 100%;
            height: auto;
            margin-left: auto;
        }

        .text {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="img-container">
            <img class="img" src="{{public_path('images/logo.png')}}" alt="Image">
        </div>
        <div class="text">
            <h4>JSR DIAMOND & JEWERLY</h4>
            Jl. Kamboja Gg. Tewaz V No. 25 Tanjung Karang Pusat Telp. 0813-6994-6343
            <br>
            <h5>Bandar Lampung</h5>
        </div>
    </header>
    <hr>
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header p-4">
                    <div class="text-center font-bold">
                        <h2 class="uppercase mb-4">Laporan Penjualan </h2>
                        {{ $period }}
                    </div>
                    <div class="text-base font-bold">
                        Cabang : {{ $cabang }}
                        <br>
                        Total Nominal : {{ format_uang($total_nominal) }}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped mb-0 text-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Cabang</th>
                                <th>Customer</th>
                                <th>Informasi Produk</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    <p class="font-bold">{{ $sale->reference }}</p>
                                    <p>{{ tanggal($sale->date) }}</p>
                                </td>
                                <td>{{ $sale->cabang->name }}</td>
                                <td>{{ $sale->customer_name }}</td>
                                <td>
                                    @php
                                        $output = collect($sale->saleDetails)->map(function ($detail, $index) {
                                            return "<p> - Produk " . ($index + 1) . " : {$detail->product->category->category_name} / {$detail->product->product_code} / {$detail->product->karat?->label} ({$detail->product->berat_emas} gr) <br> {$detail->product->berlian_short_label} </p>";
                                        })->implode('');
                                    @endphp
                                    <p>Jumlah : {{ $sale->saleDetails->count() }} buah</p>
                                    <p>Detail : {!! $output !!}</p>
                                </td>
                                <td>{{ format_uang($sale->total_amount) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <span class="text-danger">No Sales Data Available!</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>