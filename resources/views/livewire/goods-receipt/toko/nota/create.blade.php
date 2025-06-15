<div class="row">

<div class="col-lg-12">
    <div class="card">

        <div class="card-body">

            <div class="flex relative py-3">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-b border-gray-300"></div>
                </div>
                <div class="relative flex justify-left">
                    <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Nota Pengiriman Barang BuyBack - Barang Luar ke Office')}} &nbsp;<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Nota Pengiriman Barang BuyBack - Barang Luar ke Office')}}"></i>
                    </span>
                </div>
            </div>

            {{-- batas --}}

            <div class="flex flex-row grid grid-cols-1 gap-2">

                <div class="rounded-md border px-3 py-2">
                    <div class="font-semibold mb-2 border-bottom pb-2">Invoice Info: </div>
                    <div>Invoice : <strong>{{ $invoice }}</strong></div>
                    <div>Tanggal : <strong><input wire:model="date" type="date" id="date" class="font-bold @error('date') is-invalid @enderror" max="{{ $this->today }}"></strong></div>
                    <div>Cabang : <strong>{{ $cabang->name }}</strong></div>

                </div>




            </div>


            <div class="flex relative px-2 py-3 pb-3">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-b border-gray-300"></div>
                </div>
                <div class="relative flex justify-left">
                    <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                        <span class="text-green-500"> PILIH BARANG
                        </span>
                    </span>
                </div>
            </div>





            <table style="width: 100% !important;" class="table table-sm table-striped rounded rounded-lg table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">
                            <div class="p-1">
                                <input type="checkbox" wire:model="selectAll" id="select-all">
                            </div>

                        </th>
                        <th class="text-center">No</th>
                        <th class="text-center">Preview</th>
                        <th class="text-center">Tipe</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Note</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total_weight = 0;
                    @endphp
                    @forelse($goodsreceipt_items as $row)
                    @php
                    $total_weight = $total_weight + $row->gold_weight;
                    $image = $row->product->images;
                    $imagePath = '';
                    if(empty($image)){
                        $imagePath = url('images/fallback_product_image.png');
                    }else{
                        $imagePath = asset(imageUrl().$image);
                    }
                    @endphp
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" wire:model="selectedItems" value="{{$row->id}}" name="selected_items[]" />
                        </td>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="flex justify-center"> <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
                                            <img src="{{ $imagePath }}" order="0" width="100" class="img-thumbnail"/>
                                        </a>
                        </td>
                        <td class="text-center font-semibold"> {{ucwords(@$row->type_label)}}</td>
                        <td class="font-semibold">
                            <p>Nama Produk : {{@$row->product->product_name}}</p>
                            <p>Kode Produk : {{@$row->product->product_code}}</p>
                            <p>Karat : {{@$row->product->karat?->label}}</p>
                            <p>Berat : {{@$row->product->berat_emas}} gr</p>
                        </td>
                        <td class="text-center font-semibold">{{ @$row->customer_name }}</td>
                        <td class="text-center font-semibold">{{ $this->nominalText(@$row->nominal) }}</td>
                        <td class="text-center font-semibold">{{ @$row->note }}</td>
                    </tr>
                    @empty
                    <tr>
                        <th colspan="9" class="text-center">Tidak ada data</th>
                    </tr>
                    @endforelse
                    <tr>
                        <td class="border-0" colspan="3"></td>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0">

                        </td>

                    </tr>
                </tbody>

            </table>



            {{-- batas --}}

            <div class="flex justify-between">
                <div></div>
                <div class="form-group">
                    <a class="px-5 btn btn-danger" href="{{ route("buysback.index") }}">
                        @lang('Cancel')</a>
                    <a href="#" wire:click.prevent="proses" class="px-5 btn btn-success">Proses<i class="bi bi-check"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>
@include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.modal.summary')
</div>
