<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sertifikat Diamond</title>

  <link rel="stylesheet" href="{{ public_path('css/backend.css') }}">
  <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
  <style>
    @page {
      size: 8.56cm 5.398cm;
      margin: 0;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box; /* Include padding and border in the element's total width and height */
    }

    .header {
      display: flex;
      background-color: palevioletred;
      justify-content: space-between;
      padding: 1rem;
    }

    .header p {
      color: white;
      text-align: center;
      font-size: 1.5rem;
      font-weight: bold;
      margin: 0;
    }

    .header-logo {
      display: flex;
      width: 100%;
      flex-direction: column;
    }

    .konten {
      color: palevioletred;
      display: flex;
      margin-top: 1rem;
      justify-content: space-between;
      align-items: center;
      height: calc(100vh - 2rem);
    }
    .left-content, .right-content {
      float: left;
      width: 45%; /* Sesuaikan lebar sesuai kebutuhan */
      text-align: center;
    }
    
    .detail {
      float: left;
      width: 100%;
      font-size: 0.95rem;
      font-weight: bold;
      text-align: left;
    }

    .footer {
      position: absolute;
      bottom: 0.2rem;
      right: 0.2rem;
    }

  </style>
</head>
<body>

  <div class="header">
    <div class="header-logo">
      <p>JSR CERTIFICATE</p>
      <p>IDENTIFICATION MEMO</p>
    </div>
  </div>

  <div class="konten">
    <div class="left-content">
      <img width="80" src="{{ $imagePath }}">
      <div style="margin-top:1rem; text-align: center; font-size: 0.65rem; font-weight: bold;">
        {{ $product->product_code }}
      </div>
    </div>
    <div class="right-content">
      <div class="detail">
        @foreach ($diamondCertifikatAttribute as $attribute)
          <div>
            {{ $attribute->name }} : {{ $attribute->keterangan }}
          </div>
        @endforeach
      </div>

        
      
    </div>
  </div>
  <div style="relative">
    <div style="position:absolute; bottom:0.2rem;right:0.2rem;">
      <div style="font-size: 0.1rem; font-weight: bold;" class="qr-dark">
        .<img width="20" src="data:image/png;base64, {!! $barcode !!}"> 
      </div>
    </div>
  </div>



</body>
</html>
