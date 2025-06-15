<div class="row">
    <div class="col-lg-12">
        <div class="card">
         <div class="card-header justify-between d-flex flex-wrap align-items-center">
                <div>
                    <span class="font-semibold">RETUR DISTRIBUSI TOKO</span>
                </div>
                <div class="px-2">
                    {{ \Carbon\Carbon::parse(date('Y-m-d'))->format('d M, Y') }}
                </div>
                
            </div>

            <div class="card-body px-4">
                <div class="row mb-4">

                    <div class="col-sm-6 mb-4 mb-md-0">
                        <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
                        <div>Tanggal: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
                        <div>Tanggal Retur: <strong> {{ \Carbon\Carbon::parse($dist_toko->current_status_date())->format('d M, Y') }}</strong></div>
                        <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
                        <div>
                            Diretur oleh: <strong>{{ $dist_toko->current_status_pic()->name }}</strong>
                        </div>

                    </div>
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Retur Info: </div>
                        <div>Jumlah Item: <strong>{{ $dist_toko->items()->returned()->count() }} buah</strong></div>
                        <div>Jumlah Jenis Karat: <strong> {{ $dist_toko->items()->returned()->groupBy('karat_id')->count() }} </strong></div>
                        <div>Total Berat Emas: <strong> {{ $dist_toko->items()->returned()->sum('gold_weight') }} gr</strong></div>
                        <div>Alasan Retur: </br>
                            <div style="line-height: 1rem;" class="text-xs tracking-normal p-2 border border-dashed rounded-md">
                            {{ $dist_toko->current_status_note() }}</div>
                           </div>
                    </div>
                </div>

                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-gray-400">Detail Retur Distribusi

                                </span>

                        </div>
                    </div>

<table class="w-full table table-sm table-striped rounded rounded-lg table-bordered">
 <thead>
    <tr>
        
    <th class="text-center">No</th>
    <th class="text-center">Produk</th>
    <th class="text-center">Kode</th>
    <th class="text-center">Karat</th>
    <th class="text-center">Berat Emas</th>

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
                                $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                @endphp
                            <tr>

                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="font-semibold">
                                    <p>Nama : {{ @$row->product->product_name }}</p>
                                    <p>Kategori : {{ @$row->product->category->category_name }}</p>
                                </td>
                                <td class="font-semibold text-center">
                                    <p>{{ @$row->product->product_code }}</p>
                                </td>
                                <td class="text-center font-semibold"> {{@$row->product->karat->label}}</td>
                                <td class="text-center font-semibold"> {{@$row->product->berat_emas}} gr</td>
                               
                            </tr>
                            @empty
                            <tr>
                                <th colspan="5" class="text-center">Tidak ada data</th>
                            </tr>
                            @endforelse <tr>
                                <td class="border-0"></td>
                                <td class="border-0"></td>
                                <td class="border-0"></td>

                                <td colspan="5" class="border-0 text-center font-semibold">
                                    <div class="text-right px-3 text-2xl">
                                        <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                        <span class="px-2"> {{ $total_weight }} <small>GR</small></span>
                                    </div>
                                </td>
                            </tr>




</tbody>
</table>






            </div>
        </div>
    </div>
   
</div>
