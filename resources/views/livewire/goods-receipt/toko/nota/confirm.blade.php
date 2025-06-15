<div class="row w-full">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center">
                <div>
                    <span>KONFIRMASI PENERIMAAN</span>
                </div>
                <a class="btn  mfs-auto btn-sm btn-success mfe-1" href="#"><i class="bi bi-house-door"></i> Dashboard
                </a>
                <a id="Tracking" class="btn btn-sm btn-info mfe-1 d-print-none" href="#" onclick="showTracking()">
                    <i class="bi bi-save"></i> History Tracking Nota
                </a>
            </div>




            <div class="card-body px-4">
                <div class="row mb-4">

                    <div class="col-sm-6 mb-4 mb-md-0">
                        <h5 class="mb-2 border-bottom pb-2">Detail Nota:</h5>
                        <div>Invoice: <strong>{{ $nota->invoice }}</strong></div>
                        <div>Tanggal: <strong> {{ \Carbon\Carbon::parse($nota->date)->format('d M, Y') }}</strong></div>
                        <div>Cabang: <strong>{{ $nota->cabang->name }}</strong></div>
                        <div>
                            Dibuat oleh: <strong>{{ $nota->pic->name }}</strong>
                        </div>
                        <div>
                            Catatan: <strong>{{ $nota->note }}</strong>
                        </div>

                    </div>
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Detail Barang: </div>
                        <div>Jumlah Barang: <strong>{{ $nota->items()->count() }} buah</strong></div>
                    </div>
                </div>

                <div class="w-full  lg:overflow-y-auto table-responsive-sm">


                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400">Detail Barang

                                </span>

                        </div>
                    </div>


      <table style="width: 100% !important;" class="w-full table table-sm table-striped rounded rounded-lg table-bordered">
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
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_weight = 0;
                            @endphp
                            @forelse($nota->items as $row)
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
                                <td class="text-center font-semibold">
                                    @if ($row->type === 2)
                                    <a href="#" class="btn btn-sm btn-primary" wire:click.prevent="editTafsir({{$row}})">
                                        <i class="bi bi-pencil"></i> Nilai Tafsir
                                    </a>
                                    @endif
                                </td>

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



                <div class="flex justify-end items-center mt-1 gap-3">
                    <div>
                        <span class="font-bold text-gray-800-500">
                            <strong>{{ count($selectedItems) }}</strong> barang yang dipilih
                        </span>
                    </div>
                    <div>

                        <a href="#" class="px-5 btn btn-lg btn-success" wire:click.prevent="proses">Proses</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
    @include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.modal.tracking')
    @include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.modal.approve-summary')
    @include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.modal.edit_tafsir')
</div>
@push('page_scripts')
<script>
    function showTracking() {
        $('#tracking-modal').modal('show');
    }
</script>

@endpush
