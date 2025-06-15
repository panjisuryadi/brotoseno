<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>{{$title}}</title>
  
          <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
         <style>
            @page {
              size: 21.0cm 29.7cm;
              margin: 0;
            }
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 30px;
                border: 3px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                font-size: 16px;
                line-height: 24px;
                background-color:#FFFFFF;
                font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color: #555;
            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
            }

            .invoice-box table td {
                padding: 5px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(2) {
                text-align: right;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }

            .invoice-box table tr.details td {
                padding-bottom: 20px;
            } 

             .invoice-box table tr.dd td {
                padding-bottom: 2px;
            }

            .invoice-box table tr.item td {
                border-bottom: 1px solid #eee;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(2) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }

            /** RTL **/
            .invoice-box.rtl {
                direction: rtl;
                font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            }

            .invoice-box.rtl table {
                text-align: right;
            }

            .invoice-box.rtl table tr td:nth-child(2) {
                text-align: left;
            }
              .small {
               font-size: 13px !important;
            } 

              .text-blue-600 {
               color: #0f0f0f !important;
            }  
              .medium {
               font-size: 14px !important;
            }   
             .large {
               font-size: 18px !important;
            }
        </style>
    </head>

    <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <img
                                        src="{{ asset('images/logo.png')}}"
                                        style="width: 100%; max-width: 200px"
                                    />
                                </td>

                                <td>
                                    <span class="medium">Tanggal78787:  {{ tanggal($detail->date)}} </span><br />
                                    No Penerimaan Barang:  {{ $detail->code}}<br />
                                
                                </td>
                            </tr>


                       <tr class="information">
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td>
                                            {{ $detail->supplier->supplier_name }}.<br />
                                            {{ $detail->supplier->address }}<br />
                                            {{ $detail->supplier->city }}
                                        </td>

                                        <td>
                                             {{ $detail->supplier->supplier_phone }}<br />
                                             {{ $detail->supplier->supplier_email }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>







                        </table>
                    </td>
                </tr>

              

        <tr class="information">
                    <td><p class="poppins text-gray-600">{{ Label_case('Tipe Pembayaran') }}</p></td>

                    <td> 
         @if($detail->pembelian->tipe_pembayaran =='cicil')
        Cicilan : {{ $detail->pembelian->cicil }} Kali
        @elseif($detail->pembelian->tipe_pembayaran =='jatuh_tempo')
    
        <div> Jatuh Tempo : </div>
        <div>{{ tgl($detail->pembelian->jatuh_tempo) }}</div>   
         @endif
       </td>
                </tr>

<tr class="dd">
    <td>
        <div class="poppins text-gray-600">{{ Label_case('Total_berat_kotor') }}</div>
    </td>
    <td>
   <div class="poppins font-semibold text-blue-800">{{ $detail->total_berat_kotor }}
                   <small class="text-gray-700">Gram</small></div>
</td>
</tr>
<tr class="dd">
    <td>
        <div class="poppins text-gray-600">{{ Label_case('berat_timbangan') }}</div>
    </td>
    <td>
   <div class="poppins font-semibold text-blue-800">{{ $detail->berat_timbangan }}
                  </div>
</td>
</tr>



<tr class="dd">
    <td>
      <div> {{ Label_case('Total_Emas') }} <span style="font-size:0.9rem !important;" class="mt-0 small text-blue-600">Total Emas yg harus di bayar
                   </span></div>
                   
    </td>
    <td>
   <div class="poppins font-semibold text-blue-800">{{ $detail->total_emas }}
                 </div>
</td>
</tr>





      @if($detail->selisih)
                  <tr class="details">
                        <td>{{ Label_case('selisih') }}</td>
                        <td>Gram : {{ $detail->selisih }}</td>
                    </tr> 

      @endif




               {{--  <tr class="total">
                    <td></td>

                    <td>Total: $385.00</td>
                </tr> --}}
            </table>

<hr>
<p>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th class="text-center">No</th>
      <th class="text-center">Kategori</th>
      <th class="text-center">Karat</th>
      <th class="text-center">Berat Real</th>
      <th class="text-center">Berat Kotor</th>
    </tr>
  </thead>
  <tbody>

 @foreach($detail->goodsreceiptitem as $row)
   <tr>
      <th class="text-center">{{$loop->iteration}}</th>
      <td style="text-align:center;" class="text-center">{{@$row->mainkategori->name}}</td>
     <td class="text-center">{{@$row->karat?->label}}</td>
      <td class="text-center"> {{@$row->berat_real}}</td>
      <td class="text-center"> {{@$row->berat_kotor}}</td>
    
    </tr>
@endforeach



        </div>
    </body>
</html>