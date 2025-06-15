
    <table>
            <tr>
                <td>
                  Invoice: <strong>{{ $dist_toko->no_invoice }}</strong>
                </td>
                <td></td>
                 <td>
               Jumlah Item: <strong>{{ $dist_toko->items()->count() }} buah</strong>
                </td>
            </tr> 

            <tr>
                <td>
                  Tanggal Distribusi: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong>
                </td>
                <td></td>
                 <td>
                Jumlah Jenis Karat: <strong> {{ $dist_toko->items->groupBy('karat_id')->count() }} </strong>
                </td>
            </tr> 

             <tr>
                <td>
                Cabang: <strong>{{ $dist_toko->cabang->name }}</strong>
                </td>
                <td></td>
                 <td>
                Total Berat Emas: <strong> {{ $dist_toko->items->sum('gold_weight') }} gr</strong>
                </td>
            </tr>
            <tr>
                <td>
               Status: <strong>{{ $dist_toko->current_status->name }}</strong>
                </td>
                <td></td>
                 <td>
                
                </td>
            </tr>
        </table>



<table>
    <tr>
        <td><strong>Penerimaan Distribusi Toko Detail</strong></td>

    </tr>
</table>

         <table class="table">
                            <thead>
                                <tr>
                                    
            <th style="background-color: #d8dbe0;font-weight: bold;">No</th>
            <th style="background-color: #d8dbe0;font-weight: bold;">Informasi Produk</th>
            <th style="background-color: #d8dbe0;font-weight: bold;">Kode Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total_weight = 0;
                                @endphp
                                @forelse($dist_toko->items as $row)
                                @php
                                $data = json_decode($row->additional_data)->product_information;
                                $total_weight = $total_weight + $row->gold_weight;
                                $model = !empty($data->model->name) ? $data->model->name : '';
                                
                                $berlian_info = '';
                                if (!empty($data->produksi_items)) {
                                foreach($data->produksi_items as $item) {
                                $shape_code = !empty($item->shape?->shape_code) ? $item->shape?->shape_code : '';
                                $shape_name = !empty($item->shape?->shape_name) ? $item->shape?->shape_name : '';
                                $shape = !empty($shape_code) ? $shape_code : $shape_name;
                                $berlian_info .= ' '.$shape . ' '. $item->qty . ': ' . (float)$item->karatberlians . ' ct ';
                                }
                                }
                               
                                @endphp
                                <tr>
                                    
                                    <td>{{$loop->iteration}}</td>
                                    
                                    <td>
                                        <div class="p-3">
                                            <p>Nama Produk : {{ $row->product?->product_name }}</p>
                                            <p>Kategori : {{ $row->product->category->category_name ?? '-' }}</p>
                                            <p>Karat Emas : {{ $row->product->karat->label ?? '-'}}</p>
                                            <p>Berat Emas : {{ $row->product->berat_emas ?? '0'}}</p>
                                            
                                            @if(!empty($berlian_info))
                                            <br>
                                            Berlian : {{ $berlian_info }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                 
                             <strong>{{ $row->product?->product_code }}</strong>
                                       
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5">Tidak ada data</th>
                                </tr>
                                @endforelse
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>