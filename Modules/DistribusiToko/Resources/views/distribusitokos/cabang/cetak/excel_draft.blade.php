
    <table>
            <tr>
                <td>
                  Invoice: <strong>{{ $dist_toko->no_invoice }}</strong>
                </td>
                 <td>
                Jumlah Item: <strong>{{ $dist_toko->items->count() }} buah</strong>
                </td>
            </tr> 

            <tr>
                <td>
                  Tanggal Distribusi: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong>
                </td>
                 <td>
                Jumlah Jenis Karat: <strong> {{ $dist_toko->items->groupBy('karat_id')->count() }} </strong>
                </td>
            </tr> 

             <tr>
                <td>
                Cabang: <strong>{{ $dist_toko->cabang->name }}</strong>
                </td>
                 <td>
                Total Berat Emas: <strong> {{ $dist_toko->items->sum('gold_weight') }} gr</strong>
                </td>
            </tr>
            <tr>
                <td>
               Status: <strong>{{ strtoupper($dist_toko->current_status->name) }}</strong>
                </td>
                 <td>
                
                </td>
            </tr>
        </table>

@foreach($dist_toko->items->groupBy('karat_id') as $karat_id => $items)
<table>
    <tr>
        <td>
            <strong>Karat : {{$items->first()->karat->label}}</strong>
        </td>
    </tr>
</table>

<table style="width: 100% !important;">
    <thead>
        <tr style='background-color: #b5b4b3; color: #000000;'>
            <th style='background-color: #b5b4b3; color: #000000;'>No</th>
            <th style='background-color: #b5b4b3; color: #000000;'>Berat Emas</th>
            <th style='background-color: #b5b4b3; color: #000000;'>Informasi Produk</th>
            
        </tr>
    </thead>
    <tbody>
        @php
        $total_weight = 0;
        @endphp
        @forelse($items as $row)
        @php
        $data = json_decode($row->additional_data)->product_information;
        $row->gold_weight = !empty($row->gold_weight) ? $row->gold_weight : $row->berat_emas;
        $total_weight = $total_weight + $row->gold_weight;
        
        @endphp
        <tr>
            <th class="text-center">{{$loop->iteration}}</th>
            <td class="text-center font-extrabold"> {{$row->gold_weight}} gr</td>
            <td class="text-justify">
               Produk : {{ !empty($data->product_category->name) ? $data->product_category->name : '-' }}
             Group : {{ !empty($data->group->name) ? $data->group->name : '' }}
             Model : {{ !empty($data->model->name) ? $data->model->name : '' }}
             Code :{{ !empty($data->code) ? $data->code : (!empty($data->product_code) ? $data->product_code : '-')  }}
             
            </td>
            
        </tr>
        @empty
        <tr>
            <th colspan="4" class="text-center">Tidak ada data</th>
        </tr>
        @endforelse
        <tr>
            <td colspan="2"></td>
            
            <td class="text-center font-extrabold">
                <strong>Jumlah Emas :
                {{ $total_weight }} gr</strong>
            </td>
        </tr>
    </tbody>
    
</table>
@endforeach