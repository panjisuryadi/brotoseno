<form wire:submit.prevent="submit" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex relative py-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        @if (!empty($errors->messages))
                            @dd($errors)
                        @endif

                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Goods Receipts')}} <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Goods Receipts')}}"></i>
                            </span>


                        </div>


                        <a class="flex" href="{{ route('goodsreceipt.index') }}">
                            <div class="absolute bottom-7 right-0 flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
                                <i class="bi bi-house text-gray-600"></i>
                            </div>
                        </a>


                    </div>

                    <div class="flex flex-row grid grid-cols-3 gap-2">

                        <div class="px-0 py-2">
                            <div class="form-group">
                                <div class="py-1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                                        <label class="form-check-label" for="up2">Upload</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="upload" id="up1">
                                        <label class="form-check-label" for="up1">Webcam</label>
                                    </div>
                                </div>
                                <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center" wire:ignore>
                                @livewire('webcam', ['key' => 0], key('cam-'. 0))
                                </div>
                                <div id="upload1" wire:ignore>
                                    <div class="form-group">

                                        <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                            <div class="dz-message" data-dz-message>
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first('image') }}</small class="text-danger">
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="col-span-2 px-2">
                            <div class="flex flex-row grid grid-cols-2 gap-1">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'code';
                                    $field_lable = __('no_penerimaan_barang');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = 'readonly';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                    <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                    $field_name = 'no_invoice';
                                    $field_lable = __('No Surat Jalan / Invoice');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                    <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model.lazy="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <?php
                                    $field_name = 'supplier_id';
                                    $field_lable = __('Supplier');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">Supplier</label>
                                    <select class="form-control" name="{{ $field_name }}" wire:model="{{$field_name}}">
                                        <option value="" selected disabled>Select Supplier</option>
                                        @foreach($dataSupplier as $row)
                                        <option value="{{$row->id}}" {{ old('supplier_id') == $row->id ? 'selected' : '' }}>
                                            {{$row->supplier_name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif

                                </div>


                                <div class="form-group">
                                    <?php
                                    $field_name = 'tanggal';
                                    $field_lable = __('Tanggal');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                    <input id="{{ $field_name }}" type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }} max="{{ $hari_ini }}">
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>


                            </div>

                            <div class="py-2">
                                @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                                @endif

                                @foreach($inputs as $key => $value)
                                <div class="flex justify-between mt-0">
                                    <div class="add-input w-full mx-auto flex flex-row grid grid-cols-4 gap-2">

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'inputs.' . $key . '.karat_id';
                                            $field_lable = __('Parameter Karat');
                                            $field_placeholder = Label_case($field_lable);
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = '';
                                            ?>
                                            @if ($key==0)
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                            @endif
                                            <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                <option value="" selected disabled>Select Karat</option>
                                                @foreach($dataKarat as $row)
                                                <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
                                                    {{$row->name}} | {{$row->kode}}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has($field_name))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                            </span>
                                            @endif
                                        </div>


                                        


                                        <div class="form-group">
                                            <?php
                                            $field_name = 'inputs.' . $key . '.berat_real';
                                            $field_lable = label_case('Berat_real');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = '';
                                            ?>
                                            @if ($key==0)
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                            @endif
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                            @if ($errors->has($field_name))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                            </span>
                                            @endif
                                        </div>


                                        <div class="form-group">
                                            <?php
                                            $field_name = 'inputs.' . $key . '.berat_kotor';
                                            $field_lable = label_case('berat_kotor');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = '';
                                            ?>
                                            @if ($key==0)
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                            @endif
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:change="calculateTotalBeratKotor()" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">

                                            @if ($errors->has($field_name))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    @if ($key == 0)
                                    <div class="px-1 mt-4">
                                        <button class="btn text-white text-xl btn-info btn-md" wire:click.prevent="addInput()" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                                            <span wire:loading wire:target="add" class="text-center">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            </span>
                                        </button>
                                    </div>
                                    @else
                                    <div class="px-1">
                                        <button class="btn text-white text-xl btn-danger btn-md" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                                            <span wire:loading wire:target="remove({{$key}})" class="text-center">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            </span>
                                        </button>
                                    </div>
                                    @endif
                                </div>


                                @endforeach



                            </div>


                                <div class="grid grid-cols-4 gap-2">


                                    <div class="form-group">
                                        <?php
                                        $field_name = 'total_berat_real';
                                        $field_lable = label_case('total_berat_real');
                                        $field_placeholder = 0;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}
                                            <span class="text-danger small"> (yg harus dibayar)</span></label>
                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:model.debounce.1s="{{ $field_name }}" placeholder="{{ $field_placeholder }}" min="0" step="0.001" wire:change="calculateSelisih">
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'total_berat_kotor';
                                        $field_lable = label_case('total_berat_kotor');
                                        $field_placeholder = 0;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:model.lazy="{{ $field_name }}" placeholder="{{ $field_placeholder }}" readonly>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'berat_timbangan';
                                        $field_lable = label_case('berat_timbangan');
                                        $field_placeholder = 0;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" name="{{ $field_name }}" min="0" step="0.001" id="{{ $field_name }}" wire:model.debounce.1s="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:change="calculateSelisih">
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <?php
                                        $field_name = 'selisih';
                                        $field_lable = label_case($field_name);
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger small">(Gram)</span></label>
                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:model.lazy="{{ $field_name }}" placeholder="0" readonly>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                    

                                </div>

                                
                        


                            {{-- ///batas --}}


                            <div class="form-group">
                                <?php
                                $field_name = 'catatan';
                                $field_lable = __('Catatan');
                                $field_placeholder = Label_case($field_lable);
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                <textarea name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" rows="5" id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}" wire:model.lazy="{{ $field_name }}"></textarea>
                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'tipe_pembayaran';
                                    $field_lable = label_case('tipe_pembayaran');
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">Tipe Pembayaran <span class="text-danger">*</span></label>
                                    <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                        <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                        <option value="cicil">Cicil</option>
                                        <option value="jatuh_tempo">Jatuh Tempo</option>
                                        <option value="lunas">Lunas</option>
                                    </select>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                @if ($this->tipe_pembayaran == 'lunas')
                                <div class="form-group">
                                    <?php
                                    $field_name = 'harga_beli';
                                    $field_lable = label_case('harga_beli');
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}"> {{ $field_lable }} <span class="text-danger"></span></label>
                                    <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:model.lazy="{{ $field_name }}" placeholder="0">
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                @endif

                                @if ($this->tipe_pembayaran == 'cicil')
                                <div id="cicilan" class="form-group">
                                    <?php
                                    $field_name = 'cicil';
                                    $field_lable = __('cicil');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}"> {{ $field_placeholder }} <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                        <option value="" selected disabled>Jumlah {{ $field_name }}an</option>
                                        <option value="2">2 kali</option>
                                        <option value="3">3 kali </option>
                                    </select>
                                    @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                    @endif
                                </div>
                                @elseif ($this->tipe_pembayaran == 'jatuh_tempo')
                                <div id="jatuh_tempo" class="form-group">
                                    <?php
                                    $field_name = 'tgl_jatuh_tempo';
                                    $field_lable = __('Tanggal Jatuh Tempo');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                    <input type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{$field_name}}_input" wire:model="{{ $field_name }}" min="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}">
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>

                            @if ($tipe_pembayaran == 'cicil' && $cicil != '')
                            <div class="card p-6 bg-gray-100 rounded-lg shadow-md">
                                <div class="text-md font-bold mb-4">Input Tanggal Cicilan</div>

                                @for ($i = 1; $i <= $cicil; $i++)
                                    <div class="mb-4">
                                        <label for="cicilan{{ $i }}" class="text-gray-600 text-sm mb-2 block">Cicilan Ke {{ $i }}</label>
                                        <div class="relative rounded-lg">
                                            <?php
                                            $field_name = 'detail_cicilan.'.$i;
                                            $field_lable = __('Tanggal Jatuh Tempo');
                                            $field_placeholder = Label_case($field_lable);
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            ?>
                                            <input
                                                type="date"
                                                id="{{ $field_name }}"
                                                name="{{ $field_name }}"
                                                wire:model="{{ $field_name }}"
                                                wire:change="resetDetailCicilanAfterwards({{$i}})"
                                                min="{{ $this->getMinCicilDate($i)}}"
                                                class="block w-full py-2 px-3 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                            />

                                            @if ($errors->has($field_name))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                @endfor
                            </div>



                            @endif
                            

                            <div class="flex flex-row grid grid-cols-2 gap-2">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'pengirim';
                                    $field_lable = __('nama_pengirim');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                    <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" wire:model.lazy="{{ $field_name }}" placeholder="{{ $field_placeholder }}">
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                    $field_name = 'pic_id';
                                    $field_lable = __('pic');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">PIC</label>
                                    <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" value="{{ auth()->user()->name }}" placeholder="{{ $field_placeholder }}" readonly>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                {{-- batas --}}
                            </div>






                        </div>


                        {{-- batas --}}




                    </div>



                    <div class="mt-4 flex justify-between">
                        <div></div>
                        <div class="form-group">
                            <a class="px-5 btn btn-danger" href="{{ route("goodsreceipt.index") }}">
                                @lang('Cancel')</a>
                            <button type="submit" class="px-5 btn btn-success">@lang('Save') <i class="bi bi-check"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
@push('page_scripts')
<script>

</script>
@endpush
