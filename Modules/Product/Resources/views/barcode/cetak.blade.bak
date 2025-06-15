<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcodes</title>

    <link rel="stylesheet" href="{{ public_path('css/backend.css') }}">
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">

 <style>
   @page {
         size: 8.57cm 2.80cm;
          margin: 0;
        }
  </style>
<style>
.borderless td, .borderless th {
    border: none;
}
div#kanan {
  transform: rotate(180deg);
}
.tf {
  transform: rotate(180deg);
}
.qr-dark {
  color:#000;
}
</style>
</head>
<body>
<table class="table borderless">

      <tr style="border:none !important;" >

        <td  class ="text-dark" style="width:40%;border:none !important;text-align: left;">
          <div style="relative">
            <div style="position:absolute; top:1.7rem;font-size: 0.9rem;left:1rem;">
              <img width="35" src="data:image/png;base64, {!! $barcode !!}">   
            </div>
            <div style="position:absolute; bottom:1.7rem;left:1rem;">
              <div style="font-size: 0.65rem; font-weight: bold;" class="qr-dark">
                  {{$product->product_name}}
              </div>
              <div style="font-size: 1rem; font-weight: bold;" class="qr-dark">
                  {{$product->product_item[0]->berat_total ?? 0}} Ct
              </div>
              <div style="font-size: 0.65rem; font-weight: bold;" class="qr-dark">
                  {{$product->product_code}}
              </div>
            </div>
          </div>
        </td>

        <td style="border:none !important;">
          <div style="relative">
            <div class="tf" style="position:absolute; top:1.5rem;right:1.8rem;">
              <div style="font-size: 0.65rem; font-weight: bold;" class="qr-dark">
                  {{$product->product_name}}
              </div>
              <div style="font-size: 1rem;  font-weight: bold;" class="qr-dark">
                  {{$product->product_item[0]->berat_total ?? 0 }} Ct
              </div>
              <div style="font-size: 0.65rem; font-weight: bold;" class="qr-dark">
                  {{$product->product_code}}
              </div>
            </div>
            <div style="position:absolute; bottom:1.7rem;right:1.8rem;">
              <img class="tf" width="35" src="data:image/png;base64, {!! $barcode !!}">   
            </div>
          </div>   
        </td>
      
      </tr>
    
  </table>


</body>
</html>
