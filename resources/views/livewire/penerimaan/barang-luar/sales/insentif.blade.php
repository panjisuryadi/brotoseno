<form wire:submit.prevent="store">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="flex relative py-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Tambah Insentif')}} &nbsp;<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Tambah Insentif')}}"></i>
                            </span>
                        </div>
                    </div>


                    <div class="flex flex-row grid grid-cols-1 gap-2">

                        <table style="width:100%;" class="table table-borderlees">
                            <tbody>
                                <tr>

                                    <td class="w-50">
                                        <label class="px-1 font-semibold text-lg uppercase text-gray-600">Bulan </label>
                                    </td>
                                    <td class="w-50">
                                        <div class="form-group">
                                            <?php
                                            $field_name = 'bulan';
                                            $field_lable = label_case('bulan');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>

                                            <input type="month" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{$field_name}}" wire:change="pilihBulan($event.target.value)" class="form-control">
                                            </input>
                                            @if ($errors->has($field_name))
                                            <span class="invalid feedback"role="alert">
                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                class="text-danger">
                                            </span>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="w-40">
                                        <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                                            Nama Sales</label>
                                    </td>
                                    <td class="w-60">

                                        <select wire:model="sales_id" name="sales_id" class="form-control" wire:change="fetchNilai">
                                            <div wire:loading wire:target="sales_id">
                                                Processing ...
                                            </div>

                                            <option value="" selected>Pilih Sales</option>
                                            @foreach($datasales as $sales)
                                            <option value="{{ $sales->id }}">{{ $sales->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('sales_id'))
                                            <span class="invalid feedback"role="alert">
                                                <small class="text-danger">{{ $errors->first('sales_id') }}.</small
                                                class="text-danger">
                                            </span>
                                        @endif


                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-40">
                                        <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                                            Nilai Angkat </label>
                                    </td>
                                    <td class="w-50">
                                        <span>Rp. {{ number_format($this->nilai_angkat) }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="w-40">
                                        <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                                            Nilai Tafsir </label>
                                    </td>
                                    <td class="w-50">
                                        <span>Rp. {{ number_format($this->nilai_tafsir) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-40">
                                        <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                                            Selisih </label>
                                    </td>
                                    <td class="w-50">
                                        <span>Rp. {{ number_format($this->nilai_selisih) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-40">
                                        <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                                            Persentase </label>
                                    </td>
                                    <td class="w-60">
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="persentase" id="persentase" wire:model="persentase" wire:change="calculateIncentive">
                                            @if ($errors->has('persentase'))
                                            <span class="invalid feedback"role="alert">
                                                <small class="text-danger">{{ $errors->first('persentase') }}.</small
                                                class="text-danger">
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-40">
                                        <label class="px-1 font-semibold text-md mt-1 uppercase text-gray-500">
                                            Nilai insentif </label>
                                    </td>
                                    <td class="w-50">
                                        <span>Rp. {{ number_format($this->nilai_insentif) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>





                    <div class="flex justify-between">
                        <div></div>
                        <div class="form-group">
                            <a class="px-5 btn btn-danger" href="{{ route("penerimaanbarangluarsale.insentif") }}">
                                @lang('Cancel')</a>
                            <button type="submit" class="px-5 btn btn-success">@lang('Create') <i class="bi bi-check"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>