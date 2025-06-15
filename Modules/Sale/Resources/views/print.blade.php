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
        .invoice {
            width: 100%;
            margin: 0px auto;

            padding: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #e50073; /* Change text color to red */
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            color: #e50073; /* Change text color to red */
        }
        .invoice-details p {
            margin: 0;
        }
        .invoice-items {
            margin-top: 0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
       .table1 table {
            width: 100%;
            border-collapse: collapse;
        }

       .table1 th, td {
            border: none;

        }


        th, td {
            border: 1px solid #e50073; /* Change border color to red */
            padding: 8px;
            text-align: left;
            font-size: 11pt !important;
            color: #e50073; /* Change text color to red */
        }
        th{
            text-transform: uppercase;
        }
        .total {
            margin-top: 20px;
            text-align: right;
            color: #e50073; /* Change text color to red */
        }
    </style>
</head>
<body>
    <div class="invoice">

<div class="invoice-items">

<table class="table1" style='width:100%; border: none !important; font-size:14pt; font-family:calibri; border-collapse: collapse;' border="0">
    <td class="table1" width='60%' align='left' style='border: none !important;padding-right:80px; vertical-align:top'>
<div style="text-align:center;">
 {{-- <div style='font-size:16pt'><b>{{ settings()->company_name }}</b></div> --}}

<img height="93" style="height: 93px;" src="{{ asset('images/print/logo.png') }}">
<br>
    
   @if(Auth::user()->isUserCabang())
  {!! Auth::user()->namacabang()->alamat ?? '' !!} 

    <div style="position: relative;font-weight:bold;text-align: center;">
        <div style="position:absolute;right:72px;">
         <img style="height: 4px;float:left;margin-right:4px;" src="{{ asset('images/print/wa.svg') }}">
          <div style="margin-left:25px;">
         {{ ucfirst(Auth::user()->namacabang()->tlp ?? '') }}   
          </div>
       
        </div>
  

    </div>

    @else
    <div style="position: relative;font-weight:bold;text-align: center;">
        <div style="position:absolute;right:72px;">
         <img style="height: 4px;float:left;margin-right:4px;" src="{{ asset('images/print/wa.svg') }}">
          <div style="margin-left:25px;">
           {{ settings()->company_phone }}
          </div>
       
        </div>
  

    </div>
   
    @endif
  

</div>



    </td>
    <td style='border: none !important;vertical-align:top' width='40%' align='left'>
        <br>
        <br>
        <div  style="font-weight:bold;text-align: right;">
        Invoice: {{ $sale->reference }}</br>
        Tanggal : {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</br>
         </br>
        </div>
    </td>
</table>
<p></p>
<table class="invoice-items">
    <thead>
        <tr>
            <th style="width:5%;" class ="text-center">No</th>
            <th style="width:10%;" class ="text-center">Gambar</th>
            <th style="width:5%;" class ="text-center">Jumlah</th>
            <th class ="text-center">nama barang</th>
            <th class ="text-center">kode</th>
            <th class ="text-center">berat (gr)</th>
            <th class ="text-center">Harga</th>
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
     <img src="{{ $imagePath }}" order="0" height="55" ="55"/>
    
    
</td>

                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->quantity }}

                </td> 

                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product->product_name }} 
                </td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product_code }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->unit_price }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ format_currency($saleDetail->price) }}
                </td>

        </tr>
        ​
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


           @if($saleDetail->note)
            <tr>
                <td colspan ='7'>
                    <div class="text-danger">Note</div>
                    <div class="text-danger">{{ $saleDetail->note }}</div>
                 
                </td>
            </tr> 
           @endif


          <tr>
            <td colspan ='6'><div style='text-align:right'>Qty : </div></td>
            <td style='text-align:right'>{{ number_format($totalQty) }} Item</td>
        </tr>

        <tr>
            <td colspan ='6'><div style='text-align:right'>Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($total) }}</td>
        </tr>

        <tr>
            <td colspan = '6'><div style='text-align:right'>Diskon : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->discount_amount) }}</td>
        </tr>
        @if($sale->dp_payment)
        <tr>
            <td colspan ='6'><div style='text-align:right'>DP : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->dp_nominal) }}</td>
        </tr>
        @endif
        <tr>
            <td colspan ='6'><div style='text-align:right'>Grand Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->grand_total_amount) }}</td>
        </tr>
        @if($sale->dp_payment)
        <tr>
            <td colspan = '6'><div style='text-align:right'>Sisa Pembayaran : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->remain_amount) }}</td>
        </tr>
        @endif


    </tfoot>
</table>

<br>
 <table style='width:100%!important; font-size:12pt;' cellspacing='1'>
            <tr>
                <td style="border: none !important;text-align: left;" align='center'>
                 <div style="position:relative;">
           
         <div>
      <strong>Potongan Rp. :  {{ $saleDetail->note ?? '------------------------------------' }} </strong>
      </div>

       </div>     
                
                </td>
            
           <td style="text-align: left; border: none !important;" align='center'>
                    {{-- Rp {{ number_format($total) }} --}}
       <div style="position:relative;">
           
         <div>
        
           <strong>Jumlah harga Rp. :{{ number_format($sale->grand_total_amount) }}</strong>
     
    

      </div>

       </div>             
   
                </td>
            </tr>
        </table>




      <table style='width:100%!important; font-size:12pt;' cellspacing='1'>
            <tr>
            <td style="border: none !important;text-align: center;" align='center'>
                 <div style="position:relative;">
                       <div style="margin-top:9px;font-size:18px;color:#333;">
                     <i>{{ terbilang($total) }} Rupiah</i>
                       </div>

                   </div>     
                
                </td>              
            </tr>
        </table>

     <br>



<div style="padding: 2px;color: #e50073 !important;">
<p style="font-weight: bold;" class="bold">CATATAN</p>

<ol>
  <li>Emas dan Berat Barang telah di timbang dan disaksikan pembeli</li>
  <li>Barang ini dapat dijual kembali dengan potongan yang ditentukan</li>
  <li>Barang yang rusak terkena <strong>potongan hingga 30%</strong></li>
  <li>Bila dijual kembali harap membawa Surat</li>


</ol>

</div>
        <table style='width:100%!important; font-size:12pt;' cellspacing='2'>
            <tr>
                <td style="border: none !important;text-align: center;" align='center'>
                    Diterima Oleh,
                </br></br>
                </br></br>
                </br></br>
                <u>(..................................................)</u>
                </td>
                <td style='border: none !important; padding:5px; text-align:left; width:30%'></td>
                <td style="text-align: center; border: none !important;" align='center'>Hormat Kami,<br>
                <span style='font-size:12pt'><b>{{ settings()->company_name }}</b></span></br>

                </br>
                </br></br>
                </br></br>
                <u>(...................................................)</u>
                </td>
            </tr>
        </table>






        </div>






    </div>






</body>
</html>






