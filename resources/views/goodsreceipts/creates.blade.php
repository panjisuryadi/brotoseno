@extends('layouts.app')
@section('title', 'Create GoodsReceipt')


@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("goodsreceipt.index") }}">GoodsReceipt</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection

@section('content')
@push('page_css')

<style type="text/css">
    .dropzone {
        height: 280px !important;
        min-height: 190px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
    }

    .dropzone i.bi.bi-cloud-arrow-up {
        font-size: 5rem;
        color: #bd4019 !important;
    }
</style>
@endpush
<div class="container-fluid">
    <script src="{{  asset('js/jquery.min.js') }}"></script>

    <!-- HERE -->
    <!-- <form wire:submit.prevent="submit" enctype="multipart/form-data"> -->
    <form method="POST" action="./penerimaan-barangs" enctype="multipart/form-data">
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
                                        <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }} value="{{ $last_po }}">
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
                                            <!-- <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger"> -->
                                        </span>
                                        @endif
                                    </div>


                                </div>

                                <div class="py-2" >
                                    @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                    @endif
                                    <div class="overflow-x-auto">
                                        <div class="flex justify-between mt-0">
                                            <div class="add-input w-full mx-auto flex flex-row gap-2 min-w-max" id="input-container">
                                            <!-- <div class="add-input w-full mx-auto flex flex-row grid grid-cols-4 gap-2" id="input-container"> -->
                                                <div>
                                                    <div class="form-group" id="form-group-0">
                                                        <?php
                                                        $field_name = 'karat_id[0]';
                                                        $field_id   = 'karat_id_0';
                                                        $field_lable = __('Parameter Karat');
                                                        $field_placeholder = Label_case($field_lable);
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        $number_karat = explode('_', $field_id);
                                                        $number_karat = end($number_karat);
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <select class="form-control" name="{{ $field_name }}" id="{{ $field_id }}" onchange="berat_real(<?= $number_karat; ?>);">
                                                            <option value="" selected disabled>Select Karat</option>
                                                            @foreach($dataKarat as $row)
                                                            <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
                                                                {{$row->name}} | {{$row->kode}} | {{$row->coef}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
        
                                                    <div class="form-group" id="form-group-0">
                                                        <?php
                                                        // $field_name = 'inputs[0].berat_kotor';
                                                        $field_name = 'berat_kotor[0]';
                                                        $field_id   = 'berat_kotor_0';
                                                        $field_lable = label_case('berat_kotor');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        $number_kotor = explode('_', $field_id);
                                                        $number_kotor = end($number_kotor);
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_id }}" min="0" step="0.001" onchange="berat_real(<?= $number_kotor; ?>);" placeholder="{{$field_lable}}">
                                                    </div>
        
                                                    <div class="form-group" id="form-group-0">
                                                        <?php
                                                        $field_name = 'berat_real[0]';
                                                        $field_id   = 'berat_real_0';
                                                        $field_lable = label_case('Berat_real');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_id }}" min="0" step="0.001" placeholder="{{$field_lable}}" readonly>
                                                    </div>
        
                                                    <div class="form-group" id="form-group-0">
                                                        <?php
                                                        $field_name = 'quantity[0]';
                                                        $field_id   = 'quantity_0';
                                                        $field_lable = label_case('Qty');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        $number_qty = explode('_', $field_id);
                                                        $number_qty = end($number_qty);
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_id }}" min="0" step="0.001" onchange="berat_real(<?= $number_qty; ?>);" placeholder="{{$field_lable}}" >
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Add and Delete buttons -->
                                            <div class="px-1 mt-4">
                                                <button class="btn text-white text-xl btn-info btn-md" type="button" id="add-input-btn">
                                                    <span><i class="bi bi-plus"></i></span>
                                                </button>
                                            </div>

                                            <div class="px-1">
                                                <button class="btn text-white text-xl btn-danger btn-md" type="button" id="delete-input-btn">
                                                    <span><i class="bi bi-trash"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                    <div class="grid grid-cols-4 gap-2">

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'total_berat_kotor';
                                            $field_lable = label_case('total_berat_kotor');
                                            $field_placeholder = 0;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" readonly>
                                        </div>

                                        

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'total_qty';
                                            $field_lable = label_case('total_qty');
                                            $field_placeholder = 0;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'total_berat_real';
                                            $field_lable = label_case('total_berat_real');
                                            $field_placeholder = 0;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label class="mb-0" for="{{ $field_name }}" class="text-success">{{ $field_lable }}
                                                <!-- <span class="text-danger small"> (yg harus dibayar)</span> -->
                                            </label>
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" min="0" step="0.001" readonly>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'yang_harus_dibayar';
                                            $field_lable = label_case('yang_harus_dibayar');
                                            $field_placeholder = 0;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" style="background-color: #e6ffe6; color: #006400; border: 1px solid #00cc00;">
                                            <!-- <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" style="background-color: #e6ffe6; color: #006400; border: 1px solid #00cc00;"> -->
                                        </div>

                                        <div class="form-group" style="display:none;">
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

                                        <div class="form-group" style="display:none;">
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
                                        <!-- <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}"> -->
                                        <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" onchange="show_tipe_pembayaran();">
                                            <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                            <option value="cicil">Cicil</option>
                                            <!-- <option value="jatuh_tempo">Jatuh Tempo</option> -->
                                            <option value="lunas">Lunas</option>
                                        </select>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group" style="display:none;">
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

                                    <div id="cicilan" class="form-group" style="display:none;">
                                        <?php
                                        $field_name = 'cicil';
                                        $field_lable = __('cicil');
                                        $field_placeholder = Label_case($field_lable);
                                        $required = '';
                                        ?>
                                        <label class="mb-0" for="{{ $field_name }}"> {{ $field_placeholder }} <span class="text-danger">*</span></label>
                                        <!-- <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}"> -->
                                        <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" onchange="show_cicil();">
                                            <option value="" selected disabled>Jumlah {{ $field_name }}an</option>
                                            <option value="2">2 kali</option>
                                            <option value="3">3 kali </option>
                                        </select>
                                    </div>

                                    <div id="jatuh_tempo" class="form-group" style="display:none;">
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
                                </div>

                                <div class="card p-6 bg-gray-100 rounded-lg shadow-md" id="tanggal_cicilan" style="display:none;">
                                    <div class="text-md font-bold mb-4">Input Tanggal Cicilan</div>
                                    <div class="mb-4">
                                            <label for="cicilan1" class="text-gray-600 text-sm mb-2 block">Cicilan Ke 1</label>
                                            <div class="relative rounded-lg">
                                                <?php
                                                $field_name = 'detail_cicilan.1';
                                                $field_lable = __('Tanggal Jatuh Tempo');
                                                $field_placeholder = Label_case($field_lable);
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                ?>
                                                <input
                                                    type="date"
                                                    id="{{ $field_name }}"
                                                    name="{{ $field_name }}"
                                                    class="block w-full py-2 px-3 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                                />

                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="cicilan2" class="text-gray-600 text-sm mb-2 block">Cicilan Ke 2</label>
                                            <div class="relative rounded-lg">
                                                <?php
                                                $field_name = 'detail_cicilan.2';
                                                $field_lable = __('Tanggal Jatuh Tempo');
                                                $field_placeholder = Label_case($field_lable);
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                ?>
                                                <input
                                                    type="date"
                                                    id="{{ $field_name }}"
                                                    name="{{ $field_name }}"
                                                    class="block w-full py-2 px-3 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                                />
                                            </div>
                                        </div>
                                        <div class="mb-4" id="cicilan_3" style="display:none;">
                                            <label for="cicilan3" class="text-gray-600 text-sm mb-2 block">Cicilan Ke 3</label>
                                            <div class="relative rounded-lg">
                                                <?php
                                                $field_name = 'detail_cicilan.3';
                                                $field_lable = __('Tanggal Jatuh Tempo');
                                                $field_placeholder = Label_case($field_lable);
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                ?>
                                                <input
                                                    type="date"
                                                    id="{{ $field_name }}"
                                                    name="{{ $field_name }}"
                                                    class="block w-full py-2 px-3 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                                />
                                            </div>
                                        </div>
                                </div>


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
    <script>
        
    </script>
    @push('page_scripts')
    <script>
        function show_tipe_pembayaran(){
            let type = $("#tipe_pembayaran").val();
            if(type == 'cicil'){
                $("#cicilan").show();
                $("#tanggal_cicilan").show();
            }else{
                $("#cicilan").hide();
                $("#tanggal_cicilan").hide();
            }
        }

        function show_cicil(){
            let cicil  = $("#cicil").val();
            if(cicil > 2){
                $("#cicilan_3").show();
            }else{
                $("#cicilan_3").hide();
            }
        }
        function sumInputs() {
            $('#total_berat_kotor').val(0);  // Reset the total fields to 0
            $('#total_berat_real').val(0);
            $('#total_qty').val(0);

            let totalInput1 = 0;  // To hold the sum of input1 values (berat_kotor)
            let totalInput2 = 0;  // To hold the sum of input2 values (berat_real)
            let totalInput3 = 0;  // To hold the sum of input2 values (berat_real)

            let input1Elements = document.querySelectorAll('input[name^="berat_kotor"]');  

            // Select all input2 elements (berat_real)
            let input2Elements = document.querySelectorAll('input[name^="berat_real"]');    
            let input3Elements = document.querySelectorAll('input[name^="quantity"]');    

            // Sum the values of input1 (berat_kotor)
            input1Elements.forEach(function(input) {
                let value = parseFloat(input.value);
                if (!isNaN(value)) {
                    totalInput1 += value;  // Add to the sum of input1 values
                } else {
                    console.log('Invalid input in berat_kotor:', input.value);  // Debugging invalid values
                }
            });

            // Sum the values of input2 (berat_real)
            input2Elements.forEach(function(input) {
                let value = parseFloat(input.value);
                if (!isNaN(value)) {
                    totalInput2 += value;  // Add to the sum of input2 values
                } else {
                    console.log('Invalid input in berat_real:', input.value);  // Debugging invalid values
                }
            });

            input3Elements.forEach(function(input) {
                let value = parseFloat(input.value);
                if (!isNaN(value)) {
                    totalInput3 += value;  // Add to the sum of input2 values
                } else {
                    console.log('Invalid input in quantity:', input.value);  // Debugging invalid values
                }
            });

            // Log the totals for debugging
            console.log('Total Berat Kotor:', totalInput1);
            console.log('Total Berat Real:', totalInput2);
            console.log('Total qty:', totalInput3);

            // Update the total values in the form
            $('#total_berat_kotor').val(totalInput1);
            $('#total_berat_real').val(totalInput2);
            $('#total_qty').val(totalInput3);

        }

        function berat_real(number){
            $("#berat_real_"+number).val('0');
            let berat_kotor = $("#berat_kotor_"+number).val();
            let selectedOption = document.querySelector('#karat_id_'+number).selectedOptions[0].text;

            if (selectedOption && selectedOption.includes('|')) {
                let value = selectedOption.split('|')[2]?.trim(); // Using optional chaining to prevent errors

                if (value) {
                    let berat_real  = value*berat_kotor;
                    $("#berat_real_"+number).val(berat_real);
                } else {
                    console.error("Could not extract the expected value.");
                }
            } else {
                console.error("Selected option doesn't have the expected format.");
            }
            sumInputs();
        }

        let inputContainer = document.getElementById('input-container');
        let addButton = document.getElementById('add-input-btn');
        let deleteButton = document.getElementById('delete-input-btn');

        let inputCount = 1;  // To keep track of the number of inputs added

        addButton.addEventListener('click', function() {
            let clonedGroup = inputContainer.children[0].cloneNode(true); // Clones the first input group
            inputContainer.appendChild(clonedGroup);  // Appends the cloned group to the container

            let groupCount = inputContainer.children.length;  // Get the number of input groups
            let inputGroup = inputContainer.children[groupCount - 1];  // Get the last (cloned) input group

            let select = inputGroup.querySelector('select');
            let input1 = inputGroup.querySelector('input[type="number"]');
            let input2 = inputGroup.querySelectorAll('input[type="number"]')[1];
            let input3 = inputGroup.querySelectorAll('input[type="number"]')[2];

            select.id = select.id.replace('0', groupCount - 1);  // Update the ID dynamically
            select.name = select.name.replace('0', groupCount - 1);

            input1.id = input1.id.replace('0', groupCount - 1);  // Update the ID dynamically
            input1.name = input1.name.replace('0', groupCount - 1);

            input2.id = input2.id.replace('0', groupCount - 1);  // Update the ID dynamically
            input2.name = input2.name.replace('0', groupCount - 1);

            input3.id = input3.id.replace('0', groupCount - 1);  // Update the ID dynamically
            input3.name = input3.name.replace('0', groupCount - 1);

            select.addEventListener('change', function() {
                berat_real(groupCount - 1);  // Call the berat_real function with the correct index
            });

            input1.addEventListener('change', function() {
                berat_real(groupCount - 1);  // Call the berat_real function with the correct index
            });
        });

        deleteButton.addEventListener('click', function() {
            let inputGroups = inputContainer.children;
            if (inputGroups.length > 1) {  // Ensure at least one input group remains
                inputContainer.removeChild(inputGroups[inputGroups.length - 1]);  // Remove the last input group
            }
        });

    </script>
    @endpush


</div>
@endsection
<x-library.select2 />
<x-toastr />
@section('third_party_scripts')
<script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
@push('page_scripts')
<script>
    

    var uploadedDocumentMap = {}
    Dropzone.options.documentDropzone = {
        url: "{{ route('dropzone.upload') }}",
        maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, .png',
        maxFiles: 1,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
            Livewire.emit('imageUploaded',response.name);
            console.log(response.name);
        },
        removedfile: function(file) {
            file.previewElement.remove();
            var name = '';
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name;
            } else {
                name = uploadedDocumentMap[file.name];
            }
            $.ajax({
                type: "POST",
                url: "{{ route('dropzone.delete') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'file_name': `${name}`
                },
            });
            $('form').find('input[name="document[]"][value="' + name + '"]').remove();
            Livewire.emit('imageRemoved',name);
        },
        init: function() {
            @if(isset($product) && $product->getMedia('pembelian'))
            var files = {
                !!json_encode($product->getMedia('pembelian')) !!
            };
            for (var i in files) {
                var file = files[i];
                this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, file.original_url);
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
            }
            @endif
        }
    }

    window.addEventListener('webcam-image:remove', event => {
        $('#imageprev0').attr('src','');
    });
    window.addEventListener('uploaded-image:remove', event => {
        Dropzone.forElement("div#document-dropzone").removeAllFiles(true);
    });
</script>

@endpush

@push('page_scripts')

<script type="text/javascript">
    jQuery.noConflict();

    (function($) {

        $('#up1').change(function() {
            $('#upload2').toggle();
            $('#upload1').hide();
        });
        $('#up2').change(function() {
            $('#upload1').toggle();
            $('#upload2').hide();
        });

        $(document).ready(function() {
            $('.numeric').keypress(function(e) {
                var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
                if (verified) {
                    e.preventDefault();
                }
            });
        });

    })(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush