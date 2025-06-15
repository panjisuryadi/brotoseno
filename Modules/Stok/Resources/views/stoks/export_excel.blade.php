<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Report Stok | {{ $judul ?? '' }}</title>
        @include('includes.main-css')
    </head>
    <body>
        <table cellpadding="5">
            <thead>
                <tr>
                    <th style='background-color: #f952a7; color: #ffffff;'>
                        <p>
                            Laporan Stok {{ $judul }}
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
@if($data_status == 'lantakan')
    <table>
        <thead>
            <tr>
                
                <th style="background-color: #d8dbe0;font-weight: bold;">No</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Karat</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Berat</th>
                
            </tr>
        </thead>
        <tbody>

            @foreach ($data_stok as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
               
                <td>{{ @$row->karat->label }}</td>
                <td>{{ formatBerat(@$row->weight) }}</td>
                
                
            </tr> 
            @endforeach

        </tbody>
    </table>
@elseif($data_status == 'pending')
 <table>
        <thead>
            <tr>
                
                <th style="background-color: #d8dbe0;font-weight: bold;">No</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Produk</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Kategori</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Karat</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Berat Emas</th>
                
            </tr>
        </thead>
        <tbody>

            @foreach ($data_stok as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ @$row->product_name }}</td>
                <td>{{ @$row->category->category_name }}</td>
                <td>{{ @$row->karat->label }}</td>
                <td>{{ formatBerat(@$row->berat_emas) }}</td>
                
                
            </tr> 
            @endforeach

        </tbody>
    </table>
@else
   <table>
        <thead>
            <tr>
                
                <th style="background-color: #d8dbe0;font-weight: bold;">No</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Produk</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Kategori</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Karat</th>
                <th style="background-color: #d8dbe0;font-weight: bold;">Berat Emas</th>
                
            </tr>
        </thead>
        <tbody>

            @foreach ($data_stok as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ @$row->product_name }}</td>
                <td>{{ @$row->category->category_name }}</td>
                <td>{{ @$row->karat->label }}</td>
                <td>{{ formatBerat(@$row->berat_emas) }}</td>
                
                
            </tr> 
            @endforeach

        </tbody>
    </table>

@endif



</body>
</html>