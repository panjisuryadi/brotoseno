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
    <table width="100%">
        <thead>
        <h3 class="nota-title">Bukti Penerimaan Barang DP</h3>
        </thead>
        <tr>
            <td width="100%">

            <table width="100%">
                <tr>
                    
                  <td style="width: 70%!important;">
                      
<table style="margin-bottom: 1rem;">
                    <tr>
                        <td width="30%">Tanggal</td>
                        <td width="2%">:</td>
                        <td><b>{{ $datetime->format('d F Y H.i T') }}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Cabang</td>
                        <td width="2%">:</td>
                        <td><b>{{$item->cabang->name}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nama Pemilik</td>
                        <td width="2%">:</td>
                        <td><b>{{ucwords($item->owner_name)}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nomor Kontak</td>
                        <td width="2%">:</td>
                        <td><b>{{$item->contact_number}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Alamat</td>
                        <td width="2%">:</td>
                        <td><b>{{$item->address}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Karat</td>
                        <td width="2%">:</td>
                        <td><b>{{$item->product->karat->label}}</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Berat Emas</td>
                        <td width="2%">:</td>
                        <td><b>{{$item->product->berat_emas}} gr</b></td>
                    </tr>
                    <tr>
                        <td width="30%">Nominal</td>
                        <td width="2%">:</td>
                        <td><b>Rp. {{number_format($item->nominal)}}</b></td>
                    </tr>
                </table>

                  </td>



                  <td width="30%" style="vertical-align: center;">
                      
                   <?php
                     $image = $item->product->images;
                    if (empty($image)) {
                        $imagePath = public_path('images/fallback_product_image.png');
                     } else {
                        $imagePath = public_path('storage/uploads/'.$image.'');
                     }
                    
                    ?>
                     {{-- {{ $imagePath }} --}}
                  <img src="{{ $imagePath }}"/>


                  </td>

                </tr>

            </table>

                

          

                <table width="100%">
                    <thead>
                        <h4>Pembayaran</h3>
                        <h5>Tipe Pembayaran : {{ ($item->payment->type === 1)?'Jatuh Tempo':'Cicil' }}</h5>
                        @if ($item->payment->type == 2)
                        <h5>Jumlah Cicilan : {{ $item->payment->cicil }} kali</h5>
                        @endif
                    </thead>
                    <tbody>
                        @foreach ($item->payment->detail as $detail)
                            <tr>
                                <td>Pembayaran ke : {{ $detail->order_number }}</td>
                                <td>Jatuh Tempo : {{ $detail->due_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <div class="penerima">
        <p class="mb-5">PIC</p>
        <p>{{ $item->pic->name }}</p>
    </div>
</body>

</html>