
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
                Diretur oleh: <strong>{{ $dist_toko->current_status_pic()->name }}</strong>
                </td>
            </tr>
           <tr>
                <td>
              
                </td>
                 <td>
                Alasan Retur : 
                {{-- <strong>{{ $dist_toko->current_status_note() }}</strong> --}}
                </td>
            </tr>



        </table>


                    <table>
                     <thead>
                        <tr>
                            
                        <th style="background-color: #d8dbe0;font-weight: bold;">No</th>
                        <th style="background-color: #d8dbe0;font-weight: bold;">Produk</th>
                        <th style="background-color: #d8dbe0;font-weight: bold;">Kategori</th>
                        <th style="background-color: #d8dbe0;font-weight: bold;">Kode</th>
                        <th style="background-color: #d8dbe0;font-weight: bold;">Karat</th>
                        <th style="background-color: #d8dbe0;font-weight: bold;">Berat Emas</th>

                        </tr>
                      </thead>
                       <tbody>
                              @php
                            $total_weight = 0;
                            @endphp
                            @forelse($dist_toko->items()->returned()->get() as $row)
                                @php
                                $row->load('product');
                                $total_weight = $total_weight + @$row->product->berat_emas;
                                $image = $row->product?->images;
                              
                                @endphp
                            <tr>

                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>
                               {{ @$row->product->product_name }}
                                  
                                </td>
                                   <td>
                              {{ @$row->product->category->category_name }}
                                  
                                </td>
                                
                                <td>
                                    <p>{{ @$row->product->product_code }}</p>
                                </td>
                                <td> {{@$row->product->karat->label}}</td>
                                <td> {{@$row->product->berat_emas}} gr</td>
                               
                            </tr>
                            @empty
                            <tr>
                                <th colspan="5" class="text-center">Tidak ada data</th>
                            </tr>
                            @endforelse <tr>
                                <td colspan="5" class="border-0"></td>
                                

                                <td class="border-0 text-center font-semibold">
                                    <div class="text-right px-3 text-2xl">
                                        <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                        <strong class="px-2"> {{ $total_weight }} <small>GR</small></strong>
                                    </div>
                                </td>
                            </tr>




</tbody>
</table>

