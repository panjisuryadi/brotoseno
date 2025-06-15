@extends('layouts.app')
@section('title', 'Custome')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">Custome</li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection



@section('content')
{{-- @php
    dd($code);
@endphp --}}
<div class="row">
    <div class="col-12">
        <form action="{{ route('sale.custom.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn text-white text-sm btn-primary btn-md" onclick="showModal()">
                                <span > Input Sertifikat Perhiasan<i class="bi bi-plus"></i></span>
                            </button>
                            <a class="btn btn-primary">Print Sertifikat</a>
                        </div>
                    </div>
                    <p class="uppercase text-lg text-gray-600 font-semibold mt-5"> Form Hasil </p>
                    <hr style="
                        height: 1px;
                        border: none;
                        color: #333;
                        background-color: #333;">
                    <div class="flex flex-row grid grid-cols-4 gap-1 mt-2">
                        <div class="px-0 py-2 col-span-1">
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
                                    @livewire('goods-receipt-berlian.webcam')
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
                                <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" value="{{ $code }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
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
                
                            {{-- <div class="form-group">
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
                                        <option value="{{$row->id}}">
                                            {{$row->category_name}}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div> --}}
                
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
                                    step="any"
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
                                    $field_name = 'ongkos_produksi';
                                    $field_lable = label_case('Ongkos Produksi');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <?php
                                    $field_name = 'ongkos_cuci';
                                    $field_lable = label_case('Ongkos Cuci');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <?php
                                    $field_name = 'ongkos_rnk';
                                    $field_lable = label_case('Ongkos RNK');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <?php
                                    $field_name = 'ongkos_mt';
                                    $field_lable = label_case('Ongkos MT');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" min="0" step="0.001" wire:model.lazy="{{ $field_name }}" placeholder="{{$field_lable}}">
                                @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                @endif
                            </div>
                
                            <div class="form-group">
                                <?php
                                    $field_name = 'harga_jual';
                                    $field_lable = label_case('Harga Jual');
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

                            <div class="form-group">
                                <?php
                                    $field_name = 'customs_id';
                                    $field_lable = label_case('customs_id');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                ?>
                                <input class="form-control"
                                    type="hidden"
                                    value="{{ $customs_id }}"
                                    name="{{ $field_name }}"
                                    id="{{ $field_name }}"
                                    wire:model = "{{ $field_name }}"
                                    placeholder="{{ $field_placeholder }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- =================================Modal======================================== --}}

<div class="modal fade" id="singleSertifikatModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
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
                <button type="submit" class="btn btn-primary" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection

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

<x-library.select2 />
<x-toastr />
@section('third_party_scripts')
    <script src="{{  asset('js/jquery.min.js') }}"></script>
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
            $('form').append('<input type="text" name="document[]" value="' + response.name + '">');
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
                $('form').append('<input type="text" name="document[]" value="' + file.file_name + '">');
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
    function showModal(key) {
            $("#singleSertifikatModal").modal('show')
        }
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