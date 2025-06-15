<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center">
                <div>
                    <span>KONFIRMASI PENERIMAAN NOTA BUYBACK</span>
                </div>
                <a class="btn  mfs-auto btn-sm btn-success mfe-1" href="#"><i class="bi bi-house-door"></i> Dashboard
                </a>
                <a target="_blank" class="btn btn-sm btn-secondary mfe-1 d-print-none" href="#"><i class="bi bi-printer"></i> Print
                </a>
                <a id="Tracking" class="btn btn-sm btn-info mfe-1 d-print-none" href="#" onclick="showTracking()">
                    <i class="bi bi-save"></i> Tracking Nota
                </a>
            </div>




            <div class="card-body px-4">
                <div class="row mb-4">

                    <div class="col-sm-6 mb-4 mb-md-0">
                        <h5 class="mb-2 border-bottom pb-2">Detail Nota:</h5>
                        <div>Invoice: <strong>{{ $buyback_nota->invoice }}</strong></div>
                        <div>Tanggal: <strong> {{ \Carbon\Carbon::parse($buyback_nota->date)->format('d M, Y') }}</strong></div>
                        <div>Cabang: <strong>{{ $buyback_nota->cabang->name }}</strong></div>
                        <div>
                            PIC cabang: <strong>{{ $buyback_nota->pic->name }}</strong>
                        </div>

                    </div>
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Detail Barang: </div>
                        <div>Jumlah Barang: <strong>{{ $buyback_nota->items()->count() }} buah</strong></div>
                    </div>
                </div>

                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400">Detail Barang BuyBack

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
                                <th class="text-center">Produk</th>
                                <th class="text-center">Karat</th>
                                <th class="text-center">Berat Emas</th>
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
                            @forelse($buyback_nota->items as $row)
                            @php
                            $total_weight = $total_weight + $row->gold_weight;
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" wire:model="selectedItems" value="{{$row->id}}" name="selected_items[]" />
                                </td>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="text-center font-semibold"> {{@$row->product->product_name}} gr</td>
                                <td class="text-center font-semibold"> {{@$row->karat?->label}} </td>
                                <td class="text-center font-semibold">{{@$row->weight}}</td>
                                <td class="text-center font-semibold">{{ @$row->customer->customer_name }}</td>
                                <td class="text-center font-semibold">{{ $this->nominalText(@$row->nominal) }}</td>
                                <td class="text-center font-semibold">{{ @$row->note }}</td>
                                <td class="text-center font-semibold">
                                    <a href="#" class="hover:text-blue-400 btn btn-sm btn-danger px-4">Preview</a>

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

                    




            </div>
        </div>
    </div>
    @include('buysback::buysbacks.modal.tracking')
</div>
@push('page_scripts')
<script>
    function showTracking() {
        $('#tracking-modal').modal('show');
    }
</script>

@endpush