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
        <h3 class="nota-title">Bukti Penerimaan {{ ucwords($item->type_label)  }}</h3>
        </thead>
        <tr>
            <td width="100%">


<table width="100%">
    
<tr>
    
<td width="70%">
    
  <table>
                    <tr>
                        <td width="30%">Kode</td>
                        <td width="2%">:</td>
                        <td><b>{{ $item->product->product_code }}</b></td>
                    </tr>
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
                        <td width="30%">Nama Produk</td>
                        <td width="2%">:</td>
                        <td><b>{{$item->product->product_name}}</b></td>
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
                    @if (isset($item->product->product_item->certificate_id))
                    <tr>
                        <td width="30%">Certificate</td>
                        <td width="2%">:</td>
                        <td><b>{{$item->product->product_item->certificates->name}}</b></td>
                    </tr>
                    @endif
                    <tr>
                        <td width="30%">Nominal</td>
                        <td width="2%">:</td>
                        <td><b>Rp. {{number_format($item->nominal)}}</b></td>
                    </tr>
                </table>
</td>

    <td width="30%" style="vertical-align: middle;">
                      
                   <?php
                     $image = $item->product->images;
                    if (empty($image)) {
                        $imagePath = public_path('images/fallback_product_image.png');
                     } else {
                        $imagePath = public_path('storage/uploads/'.$image.'');
                     }
                    
                    ?>
                     {{-- {{ $imagePath }} --}}
                  <img width="200" src="{{ $imagePath }}"/>


                  </td>

</tr>

</table>


              
            </td>
        </tr>
    </table>

<br>
<br>
<br>
<br>
<br>
<br>


<table style='width:100%!important; font-size:12pt;' cellspacing='2'>
            <tr>
              


                <td style='border: none !important; padding:5px; text-align:left; width:30%'>
                    

                </td>
                <td style="text-align: center; border: none !important;" align='center'>
              
                </td>

  <td width="30%" style="border: none !important;text-align: center;font-weight: bold;" align='center'>
                 Customer,
                </br></br>
                </br></br>
                </br></br>
                <p>{{ $item->customer_name }}</p>
                </td>

            </tr>
        </table>



{{-- 


    <div class="penerima">
        <p class="mb-5">Customer</p>
        <p>{{ $item->customer_name }}</p>
    </div> --}}



</body>

</html>