<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@700&display=swap" rel="stylesheet">

<style>
.inconsolata {
    font-family: 'Inconsolata', monospace !important;
    font-weight: 700 !important;
    color: #000000 !important;
    -webkit-print-color-adjust: exact;
}
.font-11 {
    font-size: 0.65rem !important;
}
</style>

<div class="flex flex-row justify-center">
  <div class="justify-center items-center px-2 py-3 rounded-lg">
    <div class="row m-1" id="qrcode_image">
      <div class="col-6">
        <div class="justify-center text-center items-center img-responsive img-fluid" style="font-family: plessey;">
          {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($detail->product_code, 'QRCODE', 15, 15) !!}
        </div>
      </div>
      <div class="col-6 flex justify-center items-center">
        <div class="py-2 ml-3 inconsolata text-center font-semibold tr uppercase no-underline text-lg leading-tight" style="font-size: 80pt;">
          <br>&nbsp;<strong>{{ $detail->product_code }}</strong>
          <br style="font-size: 55pt;">&nbsp;<strong>{{ $detail->berat_emas }} gr, {{ $detail->karat->name }}|{{ $detail->karat->kode }}</strong></br>
        </div>
      </div>
    </div>

    <div class="py-0 justify-center text-center items-center mt-5">
      <button onclick="printQRCode()" class="btn btn-sm btn-info">Print QR Code</button>
    </div>
  </div>
</div>

<script>
function printQRCode() {
  const content = document.getElementById('qrcode_image').innerHTML;
  const printWindow = window.open('', '_blank', 'width=600,height=400');

  printWindow.document.write(`
    <html>
      <head>
        <title>Print QR Code</title>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@700&display=swap" rel="stylesheet">
        <style>
          body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Inconsolata', monospace !important;
            font-weight: 700 !important;
            color: #000000 !important;
            -webkit-print-color-adjust: exact;
          }

          .inconsolata {
            font-family: 'Inconsolata', monospace !important;
            font-weight: 700 !important;
            color: #000000 !important;
            -webkit-print-color-adjust: exact;
          }

          .font-11 {
            font-size: 0.65rem !important;
          }

          .text-center {
            text-align: center;
          }

          .uppercase {
            text-transform: uppercase;
          }

          .text-lg {
            font-size: 1.125rem;
          }

          .font-semibold {
            font-weight: 600;
          }

          .no-underline {
            text-decoration: none;
          }

          .leading-tight {
            line-height: 1.25;
          }

          svg {
            display: block;
            margin: auto;
            max-width: 100%;
          }
        </style>
      </head>
      <body>
        ${content}
        <script>
          window.onload = function() {
            window.print();
            window.onafterprint = function() {
              window.close();
            };
          };
        <\/script>
      </body>
    </html>
  `);

  printWindow.document.close();
}
</script>
