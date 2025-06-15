<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ $filename }}</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
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

        .nota-title,
        .nota-subtitle {
            text-align: center;
        }

        .nota-title {
            text-transform: uppercase;
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
    <table class="table table-bordered table-striped text-center mb-0">

        <thead>
            <tr>
                <th colspan="6">
                    <h3 class="text-center font-bold">LAPORAN PEMBELIAN</h3>
                    <h4 class="text-center font-bold">Periode {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }} </h4>
                </th>
            </tr>
            <tr>
                <th>@lang('Transaction Date')</th>
                <th>@lang('Transaction No')</th>
                <th>@lang('Supplier')</th>
                <th >@lang('Detail')</th>
                <th>@lang('Total')</th>
            </tr>
        </thead>
        <tbody>
        @forelse($datas as $data)
            @php $data = (object)$data; @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->date)->format('d M, Y') }}</td>
                <td>{{ $data->code }}</td>
                <td>{{ $data->supplier_name }}</td>
                <td  class="text-left">
                    <div class="text-xs">
                        <b>No. Surat Jalan / Invoice</b> : {{ $data->no_invoice }}
                    </div>

                    <div class="text-xs">
                        @php
                            $tgl_bayar = !empty($data->tgl_bayar) ?  $data->tgl_bayar : $data->date;
                        @endphp
                        <b>Tgl Bayar {{ !empty($data->nomor_cicilan) && $data->tipe_pembayaran == 'cicil'  ? '( Cicilan ke -' . $data->nomor_cicilan . ')' : ''  }}</b> : {{ \Carbon\Carbon::parse($tgl_bayar)->format('d M, Y H:i:s') }} {{-- tgl pembayarn diambil dari updated at untuk akomodir semua case pembayaran, ketika cicilan, jatuh tempo, dan lunas maka dia akan update ke table tipe pembelian--}}
                    </div>
                    {{-- <div class="text-xs">
                        <b>Karat </b>: {{ $data->goodsreceiptitem->pluck('karat.label')->implode(', ')  }}
                    </div> --}}
                    @if($data->tipe_pembayaran != 'lunas')
                    <div class="text-xs">
                        <b>Tipe Pembayaran </b>: {{ label_case($data->tipe_pembayaran)  }}
                    </div>
                    @endif
                    <div class="text-xs">
                        <b>Status Pembayaran </b>: {{ !empty($data->lunas) ? label_case($data->lunas) : ($data->tipe_pembayaran =='lunas' ? 'Lunas' : 'Belum Lunas' )  }}
                    </div>
                    @if(!empty($data->total_emas) && empty($data->total_karat))
                    <div class="text-xs">
                        <b>Berat yang dibayar</b> : {{ floatval(!empty($data->jumlah_cicilan) ? $data->jumlah_cicilan :$data->total_emas)}} gr
                    </div>
                    @elseif(empty($data->total_emas) && !empty($data->total_karat))
                    <div class="text-xs">
                        <b>Karat yang dibayar</b> : {{ $data->total_karat }} ct
                    </div>
                    @else
                    <div class="text-xs">
                        <b>Berat yang dibayar</b> : {{ floatval(!empty($data->jumlah_cicilan) ? $data->jumlah_cicilan :$data->total_emas) }} gr
                    </div>
                    <div class="text-xs">
                        <b>Karat yang dibayar</b> : {{ $data->total_karat }} ct
                    </div>

                    @endif
                    
                </td>
                <td>Rp. {{ number_format(!empty( $data->nominal) ? $data->nominal : $data->harga_beli) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <span class="text-danger">No Purchases Data Available!</span>
                </td>
            </tr>
        @endforelse
            @if(!empty($data))
            <tr>
                <td colspan="4" class="text-right">
                    <span class="">Total: </span>
                </td>
                <td> Rp. {{ number_format($total_harga) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

</body>

</html>