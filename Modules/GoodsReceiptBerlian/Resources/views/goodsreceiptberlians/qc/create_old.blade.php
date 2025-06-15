@extends('layouts.app')
@section('title', $module_title)


@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("goodsreceiptberlian.qc.index") }}">Goods Receipt Berlian</a></li>
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
    {{-- <script src="{{  asset('js/jquery.min.js') }}"></script>
    @livewire('goods-receipt-berlian.penerimaan',[
        'code'=>$code,
        'module_name' => $module_name,
        'module_action' => $module_action,
        'kasir' => $kasir,
        'module_title' => $module_title,
        'module_icon' => $module_icon,
        'module_model' => $module_model
    ]) --}}
    <form enctype="multipart/form-data" action="{{route('goodsreceiptberlian.qc.store')}}" method="POST">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex relative py-3">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-left">
                                <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Goods Receipts Berlian')}} <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Goods Receipts')}}"></i>
                                </span>
                            </div>
                            <a class="flex" href="{{ route('goodsreceiptberlian.index') }}">
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
                                        <x-library.webcam />
                                    </div>
                                    <div id="upload1">
                                        <div class="form-group">
    
                                            <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone" wire:ignore>
                                                <div class="dz-message" data-dz-message>
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" value = "{{$code}}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'nama_produk';
                                        $field_lable = __('Nama Produk');
                                        $field_placeholder = Label_case($field_lable);
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = '';
                                        ?>
                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                        <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" value = "" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                        <input type="hidden" name="kategoriproduk_id" class="form-control {{ $invalid }}" value = "2" placeholder="{{ $field_placeholder }}">
                                        <input type="hidden" name="is_qc" class="form-control {{ $invalid }}" value = "1" placeholder="{{ $field_placeholder }}">
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
                                        
                                        $hari_ini = new DateTime();
                                        $hari_ini = $hari_ini->format('Y-m-d');
                                        ?>
                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                        <input id="{{ $field_name }}" type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }} max="{{ $hari_ini }}">
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <div class="col-span-2 px-2">
                                        <table class="table table-striped">
                                            <thead>
                                                <th>Atrribute</th>
                                                <th>Keterangan</th>
                                                <th>Komen</th>
                                            </thead>
                                            <tbody>
                                                @foreach ( $qcAttribute as $val)
                                                <tr>
                                                    <td>{{ $val->attribute_name }}</td>
                                                    <td>
                                                        <?php
                                                            $field_name = 'keterangan['. $val->id .']';
                                                            $field_lable = __('keterangan');
                                                            $field_placeholder = Label_case($field_lable);
                                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                            $required = '';
                                                        ?>
                                                        <input type="text" name="{{ $field_name }}" class="form-control" name="{{ $field_name }}" value = "" placeholder="{{ $field_placeholder }}" >
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $field_name = 'note['. $val->id .']';
                                                            $field_lable = __('Komen');
                                                            $field_placeholder = Label_case($field_lable);
                                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                            $required = '';
                                                        ?>
                                                        <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" value = "" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div class="form-group">
                                <a class="px-5 btn btn-danger" href="{{ route("goodsreceiptberlian.qc.index") }}">
                                    @lang('Cancel')
                                </a>
                                <button type="submit" class="px-5 btn btn-success">@lang('Save') <i class="bi bi-check"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
        maxFiles: 3,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
            Livewire.emit('imageUploaded',response.name);
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