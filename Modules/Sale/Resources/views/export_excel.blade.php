<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Report Penjualan | {{ $judul ?? '' }}</title>
        @include('includes.main-css')
    </head>
    <body>
        <table cellpadding="5">
            <thead>
                <tr>
                    <th style='background-color: #f952a7; color: #ffffff;'>
                        <p>
                            Laporan Penjualan | JSR
                        </p>
                    </th>
                    
                </tr>
                <tr>
                    <th style='background-color: #d8dbe0; color: #000000;'>
                        <p>
                            Tanggal : {{ tgl(date('Y-m-d H:i')) }}
                        </p>
                    </th>

                </tr>
            </thead>
            
        </table>
 @php
  $data_status = $status ?? '';
 @endphp       
     {{ $data_status  }}
<table>
        <thead>
            <tr>
             <th class="text-center" style="background-color: #d8dbe0;font-weight: bold;">No</th>
             <th class="text-center" style="background-color: #d8dbe0;font-weight: bold;">Date</th>
             <th class="text-center" style="background-color: #d8dbe0;font-weight: bold;">Cabang</th>
             <th class="text-center" style="background-color: #d8dbe0;font-weight: bold;">Reference</th>
             <th class="text-center" style="background-color: #d8dbe0;font-weight: bold;">Nominal</th>
             <th class="text-center" style="background-color: #d8dbe0;font-weight: bold;">Cara Bayar</th>                
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $row)
           

          @php
         $nominal = empty($row->dp_payment) || empty($row->remain_amount) ? $row->grand_total_amount : $row->dp_nominal;
                $tb = '<div class="text-center font-bold"> 
                                        ' . format_uang($nominal) . '</div>';
                    @endphp                
 
            <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-center">{{ @tanggal($row->date) }}</td>
                <td class="text-center">{{ @$row->cabang->name }}</td>                
                <td class="text-center">{{ @$row->reference }}</td>                
                               
              
                

                <td class="text-center">
                      {!!$tb !!}
                </td>  


<td>
 <div class="items-center justify-items-center text-center">
@if ($row->tipe_bayar == 'cicilan')
  {{ rupiah($row->total_amount) }}
                       <div>  {{ shortdate($row->tgl_jatuh_tempo) }} </div>
@elseif ($row->status == 'total')
    <span class="badge badge-primary">
        {{ $row->status }}
    </span>
@else
    @foreach ($row->salePayments as $item)
        <span class="uppercase">
            {{ $item->payment_method }}
        </span>
    @endforeach
@endif
</div> 
                </td> 





            </tr> 
            @endforeach

        </tbody>
    </table>


</body>
</html>