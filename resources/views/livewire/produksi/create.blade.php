<form wire:submit.prevent="submit" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="addModalLabel">Create Produksi</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex flex-row grid grid-cols-2 gap-2">
                                @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                                @endif
                                <div class="col-span-3 px-2">
                                    <p class="uppercase text-lg text-gray-600 font-semibold">Form Sumber Bahan</p>
                                    <hr style="
                                    height: 1px;
                                    border: none;
                                    color: #333;
                                    background-color: #333;">
                                    <div class="flex flex-row grid grid-cols-3 gap-1 mt-2">
                                        <div class="form-group">
                                            <?php
                                            $field_name = 'produksi_item_id';
                                            $field_lable = label_case('Bahan / Penerimaan Barang Pcs');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_lable }}
                                                {{-- <span class="text-danger">*</span> --}}
                                            </label>
                                            <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }} wire:change="setItem({{ $this->produksi_item_id }})">
                                                <option value="">Pilih </option>
                                                @foreach($dataItemProduksi as $item)
                                                <option value="{{ $item->id }}" > {{ $item->model?->name . ' ' . $item->karat?->name . ' ' . floatval($item->berat) . ' gr'}} </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has($field_name))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                            </span>
                                            @endif
                                        </div>


                                    </div>

                                    @if($kategoriproduk_id == $id_kategoriproduk_berlian)
                                    <div class="py-2">
                                        <p class="uppercase text-lg text-gray-600 font-semibold">MATA LEPASAN</p>
                                        <hr style="
                                        height: 1px;
                                        border: none;
                                        color: #333;
                                        background-color: #333;" class="mb-2">
                                        @php
                                        $lowest_key = min(array_keys($inputs))
                                        @endphp
                                        @foreach($inputs as $key => $value)
                                        <div class="flex justify-between mt-0">
                                            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-5 gap-2">
                                                <div class="form-group">
                                                    <?php
                                                    $field_name = 'inputs.' . $key . '.type';
                                                    $field_lable = __('Pilih Tipe');
                                                    $field_placeholder = Label_case($field_lable);
                                                    $required = '';
                                                    ?>
                                                    @if ($key==$lowest_key)
                                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                    @endif
                                                    <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }}>
                                                        <option value="1"> Pcs  </option>
                                                        <option value="2" {{ !empty($inputs[$key]['produksi_item_id']) ? 'disabled' : '' }}> Mata Tabur </option>
                                                    </select>
                                                    @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                    @endif
                                                </div>
                                                @if($inputs[$key]['type'] == 2)
                                                <div class="form-group">
                                                    <?php
                                                    $field_name = 'inputs.' . $key . '.id_items';
                                                    $field_lable = "Kode Items";
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                    ?>
                                                    @if ($key==$lowest_key)
                                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                    @endif
                                                    <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }} wire:change="setSelectedItem({{ $key }})">
                                                        <option value="">Pilih </option>
                                                        @foreach($dataPenerimaanBerlian as $item)
                                                        @if($item->goodsreceiptitem->tipe_penerimaan_barang == (!empty($inputs[$key]['type']) ? $inputs[$key]['type'] : 0))
                                                        <option value="{{ $item->id }}" {{  in_array($item->id, $selectedItemId) ? 'disabled' : '' }}> {{ $item->code . ' ' . $item->klasifikasi_berlian}} </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                    @endif
                                                </div>
                                                @endif
                                                @if($inputs[$key]['type'] == 1)
                                                <div class="form-group">
                                                    <?php
                                                    $field_name = 'inputs.' . $key . '.accessories_id';
                                                    $field_lable = "Kode Items";
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                    ?>
                                                    @if ($key==$lowest_key)
                                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                    @endif
                                                    <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }} wire:change="setSelectedItem({{ $key }})">
                                                        <option value="">Pilih </option>
                                                        @foreach($dataAccessories as $item)
                                                        @if($item->type ==1)
                                                        <option value="{{ $item->id }}" {{  in_array($item->id, $selectedAccItemId) ? 'disabled' : '' }}> {{ $item->code . ' ' . $item->amount . 'ct ' . $item->accessories_berlian?->shape?->shape_name }} </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                    @endif
                                                </div>
                                                @endif
                                                @if(!empty($inputs[$key]['id_items']))
                                                @php

                                                $id_items = (int) $inputs[$key]['id_items'];
                                                $colour = !empty($dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['colour']) ? $dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['colour'] : '-';
                                                $clarity = !empty($dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['clarity']) ? $dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['clarity'] : '-';
                                                $shape = !empty($dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['shape']['shape_name']) ? $dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['shape']['shape_name'] : '-';
                                                $klasifikasi_berlian = !empty($dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['klasifikasi_berlian']) ? $dataPenerimaanBerlianArray[$id_items]['accessories']['accessories_berlian']['klasifikasi_berlian'] : '-';
                                                $karatberlians = !empty($dataPenerimaanBerlianArray[$id_items]['accessories']['amount']) ? $dataPenerimaanBerlianArray[$id_items]['accessories']['amount'] : 0;
                                                $karatberlians_terpakai = !empty($dataPenerimaanBerlianArray[$id_items]['accessories']['amount_used']) ? $dataPenerimaanBerlianArray[$id_items]['accessories']['amount_used'] : 0;
                                                $harga_beli = !empty($dataPenerimaanBerlianArray[$id_items]['harga_beli']) ? $dataPenerimaanBerlianArray[$id_items]['harga_beli'] : 0;
                                                        $hagra_beli_pcs = !empty($dataPcsArray[$id_items]['harga_beli']) ? $dataPcsArray[$id_items]['harga_beli'] : 0;
                                                $sisa_stok = $karatberlians - $karatberlians_terpakai;
                                                $inputs[$key]['sisa_stok'] = $sisa_stok;
                                                //dd($dataPenerimaanBerlianArray[$id_items]['harga_beli']);
                                                @endphp
                                                {{-- @if(!empty($inputs[$key]['type']))
                                                <div class="form-group">
                                                    Colour : {{ $colour }} <br>
                                                    Clarity : {{ $clarity }} <br>
                                                    Shape : {{ $shape }} <br>
                                                    Size : {{ $klasifikasi_berlian }} <br>
                                                    Sisa Stok : {{ $sisa_stok }}
                                                    Harga Beli : {{ $harga_beli ?? 0 }}
                                                </div>
                                                @endif --}}
                                                @endif

                                                @if($inputs[$key]['type'] == 2)
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'inputs.' . $key . '.amount';
                                                        $field_lable = "Karat Berlian";
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $readonly = !empty($inputs[$key]['produksi_item_id']) || (!empty($inputs[$key]['type']) && $inputs[$key]['type'] == 1)  ? 'readonly' : '';
                                                        $required = '';
                                                        // $field_name_shape = 'inputs.' . $key . '.shapeberlian_id';
                                                        // $field_name_qty = 'inputs.' . $key . '.qty';

                                                        ?>
                                                        @if ($key==$lowest_key)
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        @endif
                                                        <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" {{ $readonly }}>
                                                        {{-- <input class="form-control" type="hidden" name="{{ $field_name_shape }}" id="{{ $field_name_shape }}" wire:model="{{ $field_name_shape }}"> --}}
                                                        {{-- <input class="form-control" type="hidden" name="{{ $field_name_qty }}" id="{{ $field_name_qty }}" wire:model="{{ $field_name_qty }}"> --}}

                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        @php
                                                        $field_name = 'inputs.' . $key . '.qty';
                                                        $field_lable = "Qty";
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $readonly = !empty($inputs[$key]['produksi_item_id']) || (!empty($inputs[$key]['type']) && $inputs[$key]['type'] == 1)  ? 'readonly' : '';
                                                        $required = '';
                                                        @endphp
                                                        @if ($key==$lowest_key)
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        @endif
                                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" {{ $readonly }}>

                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>

                                                    @endif
                                                    <div class="form-group">
                                                        @php
                                                        $field_name = 'harga_beli';
                                                        $field_lable = "Harga Beli";
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $readonly = !empty($inputs[$key]['harga_beli']) || (!empty($inputs[$key]['type']) && $inputs[$key]['type'] == 1)  ? 'readonly' : '';
                                                        $required = '';
                                                        @endphp
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="{{ $harga_beli ?? $harga_beli_pcs ?? 0 }}" placeholder="{{$field_lable}}" {{ $readonly }} disabled>

                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>

                                                {{-- <div class="form-group">
                                                    @php
                                                    $field_name = 'inputs.' . $key . '.gia_report_number';
                                                    $field_lable = "Sertifikat GIA";
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                    @endphp
                                                    @if ($key==$lowest_key)
                                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                    @endif
                                                    <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                    @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                    @endif
                                                </div> --}}
                                            </div>
                                            @if ($key != 0 && empty($inputs[$key]['produksi_item_id']))
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


<div class="flex justify-between px-2">

<div>
<button class="btn text-white text-sm btn-info btn-md" wire:click.prevent="addInput()" wire:loading.attr="disabled">
<span wire:loading.remove wire:target="add"> Tambah Item<i class="bi bi-plus"></i></span>
<span wire:loading wire:target="add" class="text-center">
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
</span>
</button>
</div>


<div>

{{-- <button type="button" class="btn text-white text-sm btn-success btn-md" onclick="showModal()">
<span > Input Sertifikat Perhiasan<i class="bi bi-plus"></i></span>
</button>
 --}}

<button
role="button"
data-toggle="modal"
data-target="#singleSertifikatModal"
class="btn text-white text-sm btn-success btn-md">
<i class="bi bi-plus"></i>
Input Sertifikat Perhiasan
</button>






</div>




</div>




                                    @endif
                                    <div class="py-2 mt-3">
                                        <p class="uppercase text-lg text-gray-600 font-semibold"> Aksesoris </p>
                                        <hr style="
                                        height: 1px;
                                        border: none;
                                        color: #333;
                                        background-color: #333;" class="mb-2">
                                        @php $lowest_key = min(array_keys($accessories)) @endphp
                                        @foreach($accessories as $key => $value)
                                        <div class="flex justify-between mt-0">
                                            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-5 gap-2">
                                                <div class="form-group">
                                                    <?php
                                                    $field_name = 'accessories.' . $key . '.accessories_id';
                                                    $field_lable = __('Pilih Aksesoris');
                                                    $field_placeholder = Label_case($field_lable);
                                                    $required = '';
                                                    ?>
                                                    @if ($key==$lowest_key)
                                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                    @endif
                                                    <select class="form-control" name="{{ $field_name }}" wire:model = "{{ $field_name }}">
                                                        <option value="">Pilih </option>
                                                        @foreach($dataAccessories as $item)
                                                        @if($item->type !=1 )
                                                        <option value="{{ $item->id }}" > {{ $item->name }} </option>
                                                        @endif
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
                                                    $field_name = 'accessories.' . $key . '.amount';
                                                    $field_lable = "Qty";
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                    ?>
                                                    @if ($key==$lowest_key)
                                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                    @endif
                                                    <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                    @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($key != 0)
                                            <div class="px-1">
                                                <button class="btn text-white text-xl btn-danger btn-md" wire:click.prevent="removeAccessories({{$key}})" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="removeAccesories({{$key}})"><i class="bi bi-trash"></i></span>
                                                <span wire:loading wire:target="remove({{$key}})" class="text-center">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                </span>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="px-1 mt-2">
                                            <button class="btn text-white text-sm btn-info btn-md" wire:click.prevent="addInputAccessories()" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="add"> Tambah Item<i class="bi bi-plus"></i></span>
                                            <span wire:loading wire:target="add" class="text-center">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            </span>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="uppercase text-lg text-gray-600 font-semibold mt-5"> Form Hasil </p>
                                    <hr style="
                                    height: 1px;
                                    border: none;
                                    color: #333;
                                    background-color: #333;">
                                    <div class="flex flex-row grid grid-cols-4 gap-1 mt-2">
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
                                        <div class="flex flex-row col-span-2 grid grid-cols-2 gap-1 mt-2 ml-2">
                                            <div class="form-group">
                                                <?php
                                                $field_name = 'code';
                                                $field_lable = __('code');
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
                                                $field_name = 'tanggal';
                                                $field_lable = __('Tanggal');
                                                $field_placeholder = Label_case($field_lable);
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                <input id="{{ $field_name }}" type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" wire:model="{{ $field_name }}" value="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}" {{ $required }} max="{{ $hari_ini }}">
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                @php
                                                $field_name = 'category_id';
                                                $field_lable = __('Pilih Kategori');
                                                $field_placeholder = Label_case($field_lable);
                                                $required = '';
                                                @endphp
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }} <span class="text-danger">*</span></label>
                                                <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }}>
                                                    <option value="" selected >Select Tipe</option>
                                                    @foreach($dataKategoriProduk as $row)
                                                    <option value="{{$row->id}}" {{ old('category_id') == $row->id ? 'selected' : '' }}
                                                        {{ $row->kategori_produk_id != $id_kategoriproduk_berlian ? 'disabled' : '' }}>
                                                        {{$row->category_name}}
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
                                                $field_name = 'berat';
                                                $field_lable = label_case('Berat Jadi');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control"
                                                type="number"
                                                step="0.01"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                wire:model = "{{ $field_name }}"
                                                placeholder="{{ $field_placeholder }}">
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                $field_name = 'harga_jual';
                                                $field_lable = label_case('Harga');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control"
                                                type="number"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                wire:model = "{{ $field_name }}"
                                                placeholder="{{ $field_placeholder }}">
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" >Simpan</button>
            </div>
        </div>
    </form>
    {{-- Modal Sertifikat per diamond update terbaru sudah ditakedown jadi perhiasan, tapi takut berubah jadi tidak dihapus --}}
    <div class="modal fade" id="sertifikatModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <form wire:submit.prevent="" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="addModalLabel">Add Sertifikat</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="flex flex-row grid grid-cols-2 gap-2">
                                            @if (session()->has('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                            @endif
                                            <div class="col-span-3 px-2">
                                                <div class="flex flex-row grid grid-cols-2 gap-1 mt-2">
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = "sertifikat.$currentKey.code";
                                                        $field_lable = "Code";
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input class="form-control" type="text" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                        <input id="key" type="hidden" name="key" class="form-control" value="">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = "sertifikat.$currentKey.tanggal";
                                                        $field_lable = __('Tanggal');
                                                        $field_placeholder = Label_case($field_lable);
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                        <input id="{{ $field_name }}" type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" wire:model="{{ $field_name }}" value="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}" {{ $required }} max="{{ $hari_ini }}">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex flex-row grid grid-cols-2 gap-1 mt-2">
                                                    @foreach ($dataCertificateAttribute as $key => $item)
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = "sertifikat.$currentKey.attribute.$item->id.keterangan";
                                                        $field_name_attribute_id = "sertifikat.$currentKey.attribute.$item->id.diamond_certificate_attribute_id";
                                                        $field_lable = $item->name;
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input type="hidden" name="{{ $field_name_attribute_id }}" wire:model = "{{ $field_name_attribute_id }}" value="{{ $item->id }}" class="form-control">
                                                        <input class="form-control" type="text" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    {{-- Modal Sertifikat per perhiasan --}}
    <div class="modal fade" id="singleSertifikatModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <form wire:submit.prevent="" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="font-semibold text-lg modal-title"
                        id="addModalLabel">Add Sertifikat</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="flex flex-row grid grid-cols-2 gap-2">
                                            @if (session()->has('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                            @endif
                                            <div class="col-span-3 px-2">
                                                <div class="flex flex-row grid grid-cols-2 gap-1 mt-2">
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = "sertifikat.code";
                                                        $field_lable = "Code";
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input class="form-control" type="text" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                        <input id="key" type="hidden" name="key" class="form-control" value="">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = "sertifikat.tanggal";
                                                        $field_lable = __('Tanggal');
                                                        $field_placeholder = Label_case($field_lable);
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                        <input id="{{ $field_name }}" type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" wire:model="{{ $field_name }}" value="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}" {{ $required }} max="{{ $hari_ini }}">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex flex-row grid grid-cols-2 gap-1 mt-2">
                                                    @foreach ($dataCertificateAttribute as $key => $item)
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = "sertifikat.attribute.$item->id.keterangan";
                                                        $field_name_attribute_id = "sertifikat.0.attribute.$item->id.diamond_certificate_attribute_id";
                                                        $field_lable = $item->name;
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input type="hidden" name="{{ $field_name_attribute_id }}" wire:model = "{{ $field_name_attribute_id }}" value="{{ $item->id }}" class="form-control">
                                                        <input class="form-control" type="text" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>

                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="px-4 btn btn-primary" data-dismiss="modal">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
