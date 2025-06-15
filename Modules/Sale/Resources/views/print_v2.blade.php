<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice | JSR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }


        @page {
            size: 105mm 148.5mm; /* A4 size in millimeters */
            margin: 4mm; /* 20mm margin for all sides */
        }

        .invoice {
            width: 100%;
            margin: 0px auto;
           
        }
        .header {
            text-align: center;
            margin-bottom: 8px;
            color: #e50073; /* Change text color to #e50073 */
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            color: #e50073; /* Change text color to #e50073 */
        }
        .invoice-details p {
            margin: 0;
        }
        .invoice-items {
            margin-top: 0px;

        }  

        .fh {
           font-size: 7pt !important;
           line-height: 1;
           text-align: center;

        }
        table {
            width: 100%;
            border-collapse: collapse;
             border-radius: 10px;
        }


.table1 table {
            width: 100%;
            border-collapse: collapse;
             border-radius: 10px;
        }

  .table1 th, td {
            border: none;
             border-radius: 10px;

        }
  
        th, td {

            border: 1px solid #e50073; /* Change border color to red */
            padding: 2px;
            text-align: left;
            font-size: 6pt !important;
            color: #e50073; /* Change text color to red */
        }
        th{
            text-transform: uppercase;
             padding: 4px;

        }
        .total {
            margin-top: 2px;
            text-align: right;
            color: #e50073; /* Change text color to red */
        }
    </style>
</head>
<body>
<div class="invoice">

<div class="invoice-items">

<table class="table1" style='width:100%; border: none !important; font-size:15pt; font-family:calibri; border-collapse: collapse;' border="0">
    <td class="table1" width='60%' align='left' style='border: none !important;padding-right:60px; vertical-align:top'>
    <img height="40" style="height: 40px;" src="{{ asset('images/print/logo.png') }}">
<br>   

   @if(Auth::user()->isUserCabang())
  {!! Auth::user()->namacabang()->alamat ?? '' !!} 
       <div style="position: relative;font-weight:bold;text-align: center;">
     <div style="position:absolute;right:42px;">
         <img style="height: 0.1rem;float:left;margin-right:4px;" src="{{ asset('images/print/wa.svg') }}">
          <div style="margin-left:12px;">
           {{ ucfirst(Auth::user()->namacabang()->tlp ?? '') }}  
          </div>
       
        </div>
  

    </div>
    @else
    <div style="position: relative;font-weight:bold;text-align: center;">
        <div style="position:absolute;right:42px;">
         <img style="height: 0.1rem;float:left;margin-right:4px;" src="{{ asset('images/print/wa.svg') }}">
          <div style="margin-left:12px;">
           {{ settings()->company_phone }}
          </div>
       
        </div>
  

    </div>
   
    @endif




    </td>


    <td style='border: none !important;vertical-align:top' width='40%' align='left'>
        Invoice: {{ $sale->reference }}</br>
        Tanggal : {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</br>
        Kostumer: {{ $sale->customer_name }}</br>
      
    </td>
</table>
<br>
<table class="invoice-items">
    <thead>
        <tr >
            <th style="width:5%;" class ="fh text-center">No</th>
            <th style="width:10%;" class ="fh text-center">Gambar</th>
         
            <th class ="fh text-center">Barang</th>
            <th class ="fh text-center">kode</th>
            <th class ="fh text-center">berat <span style="font-size:4pt;">(gr)</span></th>
              <th style="width:5%;" class="fh text-center">Qty</th>
            <th class="fh text-center">Harga</th>
          
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        $totalPrice = 0;
        $totalQty = 0;
        $total = 0;
        @endphp
        @forelse ($sale->saleDetails as $saleDetail)
        <tr>

            <td>{{ $no++ }}</td>


<td style="text-align:center;vertical-align:bottom">
    <?php
    
    //$img = public_path('images/fallback_product_image.png')
    $image = $saleDetail->product->images;
    if (empty($image)) {
        $imagePath = public_path('images/fallback_product_image.png');
     } else {
        $imagePath = public_path('storage/uploads/'.$image.'');
     }

    
    ?>
     <img src="{{ $imagePath }}" width="28"/>
    
    
</td>

            

                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product->product_name }} 
                </td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product_code }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->unit_price }}</td>
                  <td style="text-align:center;vertical-align:bottom">
               
                    {{ @$saleDetail->quantity }}

                </td>      
                <td style="text-align:center;vertical-align:bottom">
                    {{ format_currency($saleDetail->price) }}
                </td>
             

        </tr>
       
        @php
        $totalPrice += $saleDetail->price;
        $totalQty += $saleDetail->quantity;
        $total += ($saleDetail->price * $saleDetail->quantity);
        @endphp
        @empty
        <tr>
            <td colspan="5" class="text-center">Tidak ada data</td>
        </tr>
        @endforelse


    </tbody>
    <tfoot>

      @if($sale->note)
        <tr>
            <td colspan ='7'>
                <div class="text-danger">Note</div>
                <div class="text-danger">{{ $sale->note }}</div>
             
            </td>
        </tr> 
       @endif

          <tr>
            <td colspan = '6'><div style='text-align:right'>Qty : </div></td>
            <td style='text-align:right'>{{ number_format($totalQty) }} Item</td>
        </tr>

        <tr>
            <td colspan = '6'><div style='text-align:right'>Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($total) }}</td>
        </tr>

        <tr>
            <td colspan = '6'><div style='text-align:right'>Diskon : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->discount_amount) }}</td>
        </tr>

        <tr>
            <td colspan = '6'><div style='text-align:right'>Grand Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->grand_total_amount) }}</td>
        </tr>


    </tfoot>
</table>


<hr style="color:#e50073;margin-bottom: 5pt;">
<table border="0" width="100%">
    
<tr>
<td width="60%" style="vertical-align:top;padding-top:5pt;">
<div style="margin-left:4pt;font-weight: bold;font-size: 6pt;" class="bold">CATATAN</div>
<ul style="margin-left:10pt;padding:1px;font-size:6pt;">
  <li>Emas dan Berat Barang telah di timbang dan disaksikan pembeli</li>
  <li>Barang ini dapat dijual kembali dengan potongan yang ditentukan</li>
  <li>Barang yang rusak terkena <strong>potongan hingga 30%</strong></li>
  <li>Bila dijual kembali harap membawa Surat</li>
</ul>

</td>

<td width="40%" style="vertical-align:top;padding-top:5pt;">
 <div style="margin-left:4pt;font-weight: bold;font-size: 6pt;" class="bold">LAIN - LAIN</div>   
<ul style="margin-left:10pt;padding:1px;font-size:6pt;">
  @forelse ($sale->manual as $row)
  <li> {{ $row->note }}  | {{ number_format($row->nominal) }}</li>
  @empty

  @endforelse
</ul>

</td>
</tr>


</table>



</div>




    </div>






</body>
</html>






