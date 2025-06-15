<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ $filename }}</title>
    <style type="text/css">
        body {
            font-family: Helvetica, sans-serif;
            font-size: 4mm;
        }

        h4,
        h5 {
            margin: 5px;
        }

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
            left: 37%;
            align-items: center;
            max-width: 200px;
        }

        .img {
            width: 100%;
            height: auto;
            margin-left: auto;
        }

        .text {
            margin-top: 120px;
        }

        .nota-title {
            text-align: center;
        }

        .penerima {
            float: right;
            margin-top: 150px;
            margin-right: 50px;
            font-weight: bold;
        }

        .mb-5 {
            margin-bottom: 5rem;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="img-container">
            <img class="img" src="{{ public_path('images/logo.png') }}" alt="Image">
        </div>
        <div class="text">
            <h4>JSR DIAMOND & JEWERLY</h4>
            Jl. Kamboja Gg. Tewaz V No. 25 Tanjung Karang Pusat Telp. 0813-6994-6343
            <br>
            <h5>Bandar Lampung</h5>
        </div>
    </header>
    <hr>
    <table width="100%">
        <thead>
            <h2 class="nota-title">Proses Konfirmasi Barang Buyback & Luar (toko) Oleh Office</h2>
        </thead>
        <tr>
            <td width="100%">

                <table width="100%">
                    <tr>

                        <td style="width: 50%!important;">

                            <table style="margin-bottom: 1rem;">
                                <tr>
                                    <td width="30%">Code</td>
                                    <td width="2%">:</td>
                                    <td><b>{{ ucwords($nota->invoice) }}</b></td>
                                </tr>
                                <tr>
                                    <td width="30%">Tanggal</td>
                                    <td width="2%">:</td>
                                    <td><b>{{ $datetime->format('d F Y H.i T') }}</b></td>
                                </tr>
                                <tr>
                                    <td width="30%">Cabang</td>
                                    <td width="2%">:</td>
                                    <td><b>{{ $nota->cabang->name }}</b></td>
                                </tr>
                                <tr>
                                    <td width="30%">Nama PIC</td>
                                    <td width="2%">:</td>
                                    <td><b>{{ $nota->pic?->name }}</b></td>
                                </tr>
                            </table>
                        </td>



                    </tr>

                </table>
                <hr>

                <table style="width: 100% !important;"
                    class="table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Code Produk</th>
                            <th class="text-center">Karat</th>
                            <th class="text-center">Berat</th>
                            <th class="text-center">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0
                        @endphp
                        @forelse ($nota->items as $detail)
                            <tr>
                                <td class="text-center">{{ $loop->iteration  }}</td>
                                <td class="text-center">{{ @$detail->product->product_name }}</td>
                                <td class="text-center">{{ @$detail->product->product_code }}</td>
                                <td class="text-center">{{ @$detail->product->karat?->label }}</td>
                                <td class="text-center">{{ @$detail->product->berat_emas }} gr</td>
                                <td class="text-center">Rp. {{ rupiah($detail->nominal) }}</td>
                                @php
                                    $total += $detail->nominal;
                                @endphp
                            </tr>
                        @empty
                            <tr>
                                <th colspan="8" class="text-center">Tidak ada data</th>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total:</th>
                            <th class="text-center">Rp. {{ rupiah($total) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
    {{--
    @foreach ($nota->items()->approved()->get() as $row)

    @endforeach --}}

    <div class="penerima">
        <p class="mb-5">PIC</p>
        <p>{{ $nota->pic->name }}</p>
    </div>
</body>

</html>
