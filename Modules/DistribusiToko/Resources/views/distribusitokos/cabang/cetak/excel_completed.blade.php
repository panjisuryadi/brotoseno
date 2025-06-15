
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
        <td><strong>Detail Distribusi (Approved Items)</strong></td>

    </tr>
</table>
<table border="1">
                        
                            <tr>

  <td style="background-color: #d8dbe0;font-weight: bold;">No</td>
  <td style="background-color: #d8dbe0;font-weight: bold;">Karat</td>
  <td style="font-weight: bold;background-color: #d8dbe0;">Berat Emas</td>
  <td style="background-color: #d8dbe0;font-weight: bold;">Produk</td>
  <td style="background-color: #d8dbe0;font-weight: bold;">Group</td>
  <td style="background-color: #d8dbe0;font-weight: bold;">Model</td>
  <td style="background-color: #d8dbe0;font-weight: bold;">Code</td>
                              

                            </tr>
                     
                            @php
                            $total_weight = 0;
                            @endphp
                            @forelse($dist_toko->items()->approved()->get() as $row)
                            @php
                            $data = json_decode($row->additional_data)->product_information;
                            $total_weight = $total_weight + $row->gold_weight;
                            @endphp
                            <tr>

                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center font-semibold"> {{@$row->karat?->label}}</td>
                                <td class="text-center font-semibold"> {{@$row->gold_weight}} gr</td>
                                <td class="text-center font-semibold">
                                    {{ @$data->product_category->name }}</td>
                                <td class="text-center font-semibold">{{ $data->group->name }}</td>
                                <td class="text-center font-semibold">{{ $data->model->name }}</td>
                                <td class="text-center font-semibold">{{ $data->code }}</td>
                               

                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">Tidak ada data</th>
                            </tr>
                            @endforelse
                            <tr>
                                <td class="border-0" colspan="3"></td>
                                <td class="border-0"></td>
                                <td class="border-0"></td>



                                <td colspan="3" class="border-0 text-center font-semibold">
                                    <div class="text-right px-3 text-2xl">
                                        <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                        <span class="px-2">
                                         <strong>{{ $total_weight }}</strong>   
                                          <small>GR</small>
                                      </span>
                                    </div>
                                </td>
                            </tr>
                     
                    </table>


<table>
    <tr>
        <td><strong>Detail Distribusi (Returned Items)</strong></td>
    </tr>
</table>

        <table>
                        <thead>
                            <tr>

                                <td style="background-color: #d8dbe0;font-weight: bold;">No</td>
                                <td style="background-color: #d8dbe0;font-weight: bold;">Karat</td>
                                <td style="background-color: #d8dbe0;font-weight: bold;">Berat Emas</td>
                                <td style="background-color: #d8dbe0;font-weight: bold;">Produk</td>
                                <td style="background-color: #d8dbe0;font-weight: bold;">Group</td>
                                <td style="background-color: #d8dbe0;font-weight: bold;">Model</td>
                                <td style="background-color: #d8dbe0;font-weight: bold;">Code</td>
                              

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_weight = 0;
                            @endphp
                            @forelse($dist_toko->items()->returned()->get() as $row)
                            @php
                            $data = json_decode($row->additional_data)->product_information;
                            $total_weight = $total_weight + $row->gold_weight;
                            @endphp
                            <tr>

                                <td>{{$loop->iteration}}</td>
                                <td> {{@$row->karat?->label}}</td>
                                <td> {{@$row->gold_weight}} gr</td>
                                <td>{{ $data->product_category->name }}</td>
                                <td>{{ $data->group->name }}</td>
                                <td>{{ $data->model->name }}</td>
                                <td>{{ $data->code }}</td>
                               

                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">Tidak ada data</th>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="3"></td>
                                <td></td>
                                <td></td>

                                <td colspan="3">
                                    <div class="text-right px-3 text-2xl">
                                        <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                        <span class="px-2"> 
                                         <strong>{{ $total_weight }}</strong>   
                                        <small>GR</small></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>                 