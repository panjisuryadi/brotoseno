<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ $filename }}</title>
    <style type="text/css">

        body {
            font-family: Helvetica,sans-serif;
        }
        h4,h5{
            margin: 5px;
        }

        .header {
            text-align: center;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Memberikan tinggi sebesar viewport height untuk membuatnya vertikal di tengah */
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
        .text{
            margin-top: 120px;
        }

        .nota-title{
            text-align: center;
        }

        .penerima {
            float: right;
            margin-top: 75px;
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
    <table width="100%">
        <thead>
        <h3 class="nota-title">Bukti Pembayaran Barang DP</h3>
        </thead>
        <tr>
            <td width="100%">
                <table width="100%" style="margin-bottom: 1rem;">
                    <tr>
                        <td width="30%">Tanggal Pembayaran</td>
                        <td width="2%">:</td>
                        <td><b>{{ tanggal($date) }}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nama Pemilik</td>
                        <td width="2%">:</td>
                        <td><b>{{ucwords($dp->owner_name)}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nomor Kontak</td>
                        <td width="2%">:</td>
                        <td><b>{{$dp->contact_number}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Alamat</td>
                        <td width="2%">:</td>
                        <td><b>{{$dp->address}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Karat</td>
                        <td width="2%">:</td>
                        <td><b>{{$dp->product->karat->label}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Berat Emas</td>
                        <td width="2%">:</td>
                        <td><b>{{$dp->product->berat_emas}} gr</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nominal</td>
                        <td width="2%">:</td>
                        <td><b>{{format_uang($dp->nominal)}}</b></td>
                    </tr>
                    
                    <h3></h3>

                    <tr>
                        <td width="30%">Tipe Pembayaran</td>
                        <td width="2%">:</td>
                        <td><b>{{ ($dp->payment->type === 1)?'Jatuh Tempo':'Cicil' }}</b></td>
                    </tr>
                    @if($dp->payment->type == 1)
                    <tr>
                        <td width="30%">Jatuh Tempo</td>
                        <td width="2%">:</td>
                        <td><b>{{ tanggal($detail->due_date) }}</b></td>
                    </tr>
                    @elseif ($dp->payment->type == 2)
                    <tr>
                        <td width="30%">Jumlah Cicilan</td>
                        <td width="2%">:</td>
                        <td><b>{{ $dp->payment->cicil }} kali</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Pembayaran Cicilan Ke</td>
                        <td width="2%">:</td>
                        <td><b>{{ $detail->order_number }}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nominal yang dibayarkan</td>
                        <td width="2%">:</td>
                        <td><b>{{format_uang($detail->nominal)}}</b></td>
                    </tr>
                    <tr style="margin-bottom: 1rem;">
                        <td width="30%">Biaya Box</td>
                        <td width="2%">:</td>
                        <td><b>{{format_uang($detail->box_fee)}}</b></td>
                    </tr>
                    @endif
                    <h3></h3>
                    @php
                        $paid_nominal = $dp->payment->detail()->where('order_number','<=',$detail->order_number)->sum('nominal');
                        $remainder_nominal = $dp->nominal - $paid_nominal;
                    @endphp
                    <tr>
                        <td width="40%">Total Nominal yang telah dibayar</td>
                        <td width="2%">:</td>
                        <td><b>{{ format_uang($paid_nominal) }}</b></td>
                    </tr>
                    <tr>
                        <td width="40%">Sisa Nominal yang harus dibayar</td>
                        <td width="2%">:</td>
                        <td><b>{{ format_uang($remainder_nominal) }}</b></td>
                    </tr>
                    @if ($remainder_nominal === 0)
                    <tr>
                        <td width="40%">Status</td>
                        <td width="2%">:</td>
                        <td><b>LUNAS</b></td>
                    </tr>
                    @endif
                </table>
                        
            </td>
        </tr>
    </table>

    <div class="penerima">
        <p class="mb-5">PIC</p>
        <p>{{ $detail->pic->name }}</p>
    </div>
</body>

</html>