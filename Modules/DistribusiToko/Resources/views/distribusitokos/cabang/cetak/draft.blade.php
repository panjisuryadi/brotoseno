<div class="row">
        <div class="col-lg-12">
            <div class="card">


                <div class="card-header">
                    <h1 class="text-lg font-bold">Summary Distribusi</h1>
                </div>
                <div class="card-body">

<div class="w-full flex justify-between px-1 py-2">
    
    <div class="px-2">
        <div class="font-extrabold mb-2">Invoice Info: </div>
        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
        <div>Tanggal: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
        <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
        <div>
            Dibuat oleh: <strong>{{ $dist_toko->created_by }}</strong>
        </div>
        <div>
            {{ Label_case('Status') }}: <label class="bg-green-400 rounded-md py-0 px-3">Draft</label>
        </div>
    </div>
    <div class="px-2 mr-5">
        <div class="font-extrabold mb-2">Distribusi Info: </div>
        <div>Jumlah Item: <strong>{{ $dist_toko->items->count() }} buah</strong></div>
        <div>Jumlah Jenis Karat: <strong> {{ $dist_toko->items->groupBy('karat_id')->count() }} </strong></div>
        <div>Total Berat Emas: <strong> {{ $dist_toko->items->sum('gold_weight') }} gr</strong></div>
    </div>
</div>


                    <div class="card">
                        <div class="card-header">
                           <span class="text-gray-600 text-md font-semibold">Detail</span>
                        </div>



                        <div class="card-body">

                            <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                              
                   @foreach($dist_toko->items->groupBy('karat_id') as $karat_id => $items)
                                <h4 class="font-bold uppercase mb-3">Karat : {{$items->first()->karat->label}}</h4>
                                <table style="width: 100% !important;" class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Berat Emas</th>
                                        <th class="text-center">Informasi Produk</th>
                                           
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
                                            $image = $row->product?->images;
                                            $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                        @endphp
                                        <tr>
                                            <th class="text-center">{{$loop->iteration}}</th>
                                            <td class="text-center font-extrabold"> {{$row->gold_weight}} gr</td>
                                            <td class="text-justify">
                                                <div>
                                                    Produk : <strong>{{ !empty($data->product_category->name) ? $data->product_category->name : '-' }}</strong>
                                                </div>
                                                <div>
                                                    Group : <strong>{{ !empty($data->group->name) ? $data->group->name : '' }}</strong>
                                                </div>
                                                <div>
                                                    Model : <strong>{{ !empty($data->model->name) ? $data->model->name : '' }}</strong>
                                                </div>
                                                <div>
                                                    Code : <strong>{{ !empty($data->code) ? $data->code : (!empty($data->product_code) ? $data->product_code : '-')  }}</strong>
                                                </div>
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
                                               <span>Jumlah Emas : </span> {{ $total_weight }} gr
                                            </td>
                                        </tr>
                                    </tbody>
                                    @if ($errors->has('total_weight_per_karat.'.$karat_id))
                                                    <span class="invalid feedback"role="alert">
                                                        <small class="text-danger">{{ $errors->first('total_weight_per_karat.'.$karat_id) }}.</small
                                                            class="text-danger">
                                                    </span>
                                    @endif
                                </table>
                                @endforeach














                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>