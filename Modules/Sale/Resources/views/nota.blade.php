<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
     <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
             color: #e50073;
            padding: 0;
        }

         @page {
            margin-top: 1pt;
            margin-bottom: 1pt;
         }

        @media print {
             body {margin-top: 50mm; margin-bottom: 50mm; 
                   margin-left: 0mm; margin-right: 50mm}
        }

        .invoice {
            width: 100%;
            margin: 0px auto;

            padding: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
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
             border: 1px solid #fff;

        }

        td {
            border: 1px solid #e50073; /* Change border color to red */
            padding: 4px;
            text-align: left;
            font-size: 8pt !important;
            color: #e50073; /* Change text color to red */
        }
        th{
            text-transform: uppercase;
              border: 1px solid #e50073; /* Change border color to red */
            font-size: 8pt !important;
            color: #e50073; /* Change text color to red */
        }
        .total {
            margin-top: 20px;
            text-align: right;
            color: #e50073; /* Change text color to red */
        }
   
        small{font-size:11px;}


    </style>
</head>
<body>

<div style="margin:0 auto">
    <div style="color:#e50073;" id="receipt-data">


<table style="width:91mm" class="table1">
    <tr>
        <td style="border:none;">
            
  <img height="37" style="height: 37px;" src="{{ asset('images/print/logo.png') }}">
<br>   

   @if(Auth::user()->isUserCabang())
  {!! Auth::user()->namacabang()->alamat ?? '' !!} 
       <div style="position: relative;font-weight:bold;text-align: center;">
      <div style="position:absolute;right:52px;">
         <img style="height: 2px;float:left;margin-right:4px;" src="{{ asset('images/print/wa.svg') }}">
          <div style="margin-left:12px;">
           {{ ucfirst(Auth::user()->namacabang()->tlp ?? '') }}  
          </div>
       
        </div>
  

    </div>
    @else
    <div style="position: relative;font-weight:bold;text-align: center;">
        <div style="position:absolute;right:52px;">
         <img style="height: 2px;float:left;margin-right:4px;" src="{{ asset('images/print/wa.svg') }}">
          <div style="margin-left:12px;">
           {{ settings()->company_phone }}
          </div>
       
        </div>
  

    </div>
   
    @endif

        </td>
         <td style="border:none;">
            
   <div style="font-size: 12px;line-height:15px; font-weight:bold;margin-top: 9px;">
            Tanggal: {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}<br>
            Invoice: {{ $sale->reference }}
            <br>
            Customer: {{ $sale->customer_name }}
        </div>

        </td> 
    </tr>
</table>

    

<br>
 


<table style="width:91mm" class="invoice-items">
    <thead>
        <tr>
            <th>#</th>
            <th style="width:10%;">Photo</th>
            <th style="width:5%;">Qty</th>
            <th>Barang</th>
            <th>kode</th>
            <th>berat (gr)</th>
            <th>Harga</th>
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
                     $image = $saleDetail->product->images;
                    if (empty($image)) {
                        $imagePath = public_path('images/fallback_product_image.png');
                     } else {
                        $imagePath = public_path('storage/uploads/'.$image.'');
                     }
                    
                    ?>
                     {{-- {{ $imagePath }} --}}
                  <img width="27" src="{{ $imagePath }}"/>



                </td>

                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->quantity }}</td>


                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product->product_name }} </td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product_code }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->unit_price }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ format_currency($saleDetail->price) }}
                </td>

        </tr>



           @if($saleDetail->note)
            <tr>
                <td colspan ='7'>
                    <div class="text-danger">Note</div>
                    <div class="text-danger">
                        {{ $saleDetail->note }}</div>
                 
                </td>
            </tr> 
           @endif




        @php
        $totalPrice += $saleDetail->price;
        $totalQty += $saleDetail->quantity;
        $total += ($saleDetail->price * $saleDetail->quantity);
        @endphp
        @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data</td>
        </tr>
        @endforelse


    </tbody>
    <tfoot>

 

        <tr>
            <td colspan ='6'><div style='text-align:right'>Qty : </div></td>
            <td style='text-align:right'>{{ number_format($totalQty) }} Item</td>
        </tr>

        <tr>
            <td colspan ='6'><div style='text-align:right'>Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($total) }}</td>
        </tr>

        <tr>
            <td colspan ='6'><div style='text-align:right'>Diskon : </div></td>
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
            <td colspan ='6'><div style='text-align:right'>Sisa Pembayaran : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->remain_amount) }}</td>
        </tr>
        @endif


    </tfoot>
</table>


<br>
 <table style='width:191mm!important; font-size:12pt;' cellspacing='1'>
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
        
        <strong>Jumlah harga Rp {{ number_format($sale->grand_total_amount) }}</strong>
     
    

      </div>

       </div>             
   
                </td>
            </tr>
        </table>


    </div>
</div>

</body>
</html>
