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
                        <h2 class="uppercase mb-4">Laporan Hutang Pembelian </h2>
                        {{ $period }}
                    </div>
                    <div class="text-base font-bold">
                        Tipe Pembayaran : {{ $payment }}<br>
                        Supplier : {{ $supplier }}<br>
                        Sisa Hutang : {{ $total_debt }} gr
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped mb-0 text-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Berat / Karat</th>
                                <th>Supplier</th>
                                <th>Tipe Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($gr as $item)
                            <tr>
                                <td>
                                    <p class="font-bold">{{ $item->code }}</p>
                                    <p>{{ tanggal($item->date) }}</p>
                                </td>
                                <td>
                                    <p>
                                     Karat : <span class="font-bold">{{ $item->goodsreceiptitem->pluck('karat.label')->implode(', ') }}</span>
                                    </p>
                                    <p>
                                     Total Berat Kotor : <span class="font-bold">{{ $item->total_berat_kotor }} gr</span>
                                    </p>
                                    <p>
                                     Total Berat Emas : <span class="font-bold">{{ $item->total_emas }} gr</span>
                                    </p>
                                    <p>
                                     @php
                                         $sisa_hutang = $item->total_emas - $item->pembelian->detailCicilan->sum('jumlah_cicilan');
                                     @endphp
                                     Sisa Hutang : <span class="font-bold">{{ $sisa_hutang }} gr</span>
                                    </p>
                                </td>
                                <td>
                                    <p>{{ $item->supplier->supplier_name }}</p>
                                </td>
                                <td>
                                    @php
                                    if ($item->pembelian->tipe_pembayaran == 'jatuh_tempo') 
                                    {
                                        $info =  'Jatuh Tempo';
                                        $pembayaran =  tanggal(@$item->pembelian->jatuh_tempo);
                                        if(!empty(@$item->pembelian->lunas) && @$item->pembelian->lunas == 'lunas') {
                                            $info .=' (Lunas) ';
                                        }
                                    }else if ($item->pembelian->tipe_pembayaran == 'cicil') 
                                    {
                                        $info =  'Cicilan';
                                        $pembayaran =  @$item->pembelian->cicil .' kali';
                                        if(!empty(@$item->pembelian->lunas) && @$item->pembelian->lunas == 'lunas') {
                                            $pembayaran .=' (Lunas) ';
                                        }
                                    }
                                    else{
                                        $info =  '';
                                        $pembayaran =  'Lunas';
                                    }
                                    @endphp
                                    <div class="items-left text-left">
                                        <p class="small text-gray-800">{{ $info }}</p>
                                        <p class="text-gray-800">{{$pembayaran}}</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">
                                    <span class="text-danger">No Data Available!</span>
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