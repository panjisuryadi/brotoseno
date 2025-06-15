    <div class="row">

        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">

                    <div class="flex relative py-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Buys Back Nota')}} &nbsp;<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Buys back Nota')}}"></i>
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
                            @forelse($buyback_items as $row)
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
        @include('buysback::buysbacks.cabang.modal.summary')
    </div>