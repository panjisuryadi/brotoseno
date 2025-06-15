@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("gudang.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item active">{{$module_action}}</li>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <script src="{{  asset('js/jquery.min.js') }}"></script>
                    <form action="{{ route(''.$module_name.'.update', $detail) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="flex relative py-3">
                                            <div class="absolute inset-0 flex items-center">
                                                <div class="w-full border-b border-gray-300"></div>
                                            </div>
                                            <div class="relative flex justify-left">
                                                <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Goods Receipts')}} <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Goods Receipts')}}"></i>
                                                </span>
                                            </div>
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
                                                        <input class="form-check-input" type="radio" name="upload"
                                                        id="up1">
                                                        <label class="form-check-label" for="up1">Webcam</label>
                                                    </div>
                                                </div>
                                                <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center">
                                                    <x-library.webcam />
                                                </div>
                                                <div id="upload1"">
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
                                                        <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                        <input type="text" name="{{ $field_name }}"
                                                        class="form-control {{ $invalid }}"
                                                        name="{{ $field_name }}"
                                                        value="{{ $detail->code }}"
                                                        placeholder="{{ $field_placeholder }}" {{ $required }}>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback"role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                            class="text-danger">
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
                                                        <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                        <input type="text" name="{{ $field_name }}"
                                                        class="form-control {{ $invalid }}"
                                                        name="{{ $field_name }}"
                                                        value="{{ $detail->no_invoice }}"
                                                        placeholder="{{ $field_placeholder }}" {{ $required }}>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback"role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                            class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="supplier_id">Supplier</label>
                                                        <select class="form-control select2" name="supplier_id">
                                                            <option value="" selected disabled>Select Supplier</option>
                                                            @foreach(\Modules\People\Entities\Supplier::all() as $row)
                                                            <option value="{{$row->id}}" {{ old('supplier_id') == $row->id ? 'selected' : '' }}>
                                                            {{$row->supplier_name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'date';
                                                        $field_lable = __('Tanggal');
                                                        $field_placeholder = Label_case($field_lable);
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                        <input type="date" name="{{ $field_name }}"
                                                        class="form-control {{ $invalid }}"
                                                        name="{{ $field_name }}"
                                                        value="{{ $detail->date }}"
                                                        placeholder="{{ $field_placeholder }}" {{ $required }}>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback"role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                            class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'berat_barang';
                                                        $field_lable = label_case('berat_surat_jalan');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = "required";
                                                        ?>
                                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                        <input class="form-control"
                                                        type="number"
                                                        name="{{ $field_name }}"
                                                        min="0" step="0.01"
                                                        id="{{ $field_name }}"
                                                        value="{{ $detail->berat_barang }}"
                                                        placeholder="{{ $field_placeholder }}">
                                                        <span class="invalid feedback" role="alert">
                                                            <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                        </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'berat_real';
                                                        $field_lable = label_case('berat_real');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = "required";
                                                        ?>
                                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                        <input class="form-control"
                                                        type="number"
                                                        name="{{ $field_name }}"
                                                        min="0" step="0.01"
                                                        id="{{ $field_name }}"
                                                        value="{{ $detail->berat_real }}"
                                                        placeholder="{{ $field_placeholder }}">
                                                        <span class="invalid feedback" role="alert">
                                                            <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex flex-row grid grid-cols-3 gap-2">
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'qty';
                                                        $field_lable = label_case('qty Nota');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = "required";
                                                        ?>
                                                        <label class="mb-1" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                        <input class="form-control"
                                                        type="number"
                                                        name="{{ $field_name }}"
                                                        min="1"
                                                        id="{{ $field_name }}"
                                                        value="{{ $detail->qty }}"
                                                        placeholder="{{ $field_placeholder }}">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback"role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                            class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'qty_diterima';
                                                        $field_lable = label_case('qty_diterima');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = "required";
                                                        ?>
                                                        <label class="mb-1" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                        <input class="form-control"
                                                        type="number"
                                                        name="{{ $field_name }}"
                                                        min="1"
                                                        id="{{ $field_name }}"
                                                        value="{{ $detail->qty_diterima }}"
                                                        placeholder="{{ $field_placeholder }}">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback"role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                            class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-1" for="status">Status <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" name="status" id="status">
                                                            <option value="1">Di Terima</option>
                                                            <option value="2">Di Retur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                    $field_name = 'note';
                                                    $field_lable = __('Catatan');
                                                    $field_placeholder = Label_case($field_lable);
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                    ?>
                                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                    <textarea name="{{ $field_name }}"
                                                    placeholder="{{ $field_placeholder }}"
                                                    rows="5"
                                                    id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}"></textarea>
                                                    @if ($errors->has($field_name))
                                                    <span class="invalid feedback"role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                        class="text-danger">
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="flex flex-row grid grid-cols-2 gap-2">
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'pengirim';
                                                        $field_lable = __('nama_pengirim');
                                                        $field_placeholder = Label_case($field_lable);
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                        <input type="text" name="{{ $field_name }}"
                                                        class="form-control {{ $invalid }}"
                                                        name="{{ $field_name }}"
                                                        value="{{ $detail->pengirim }}"
                                                        placeholder="{{ $field_placeholder }}" {{ $required }}>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback"role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                            class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="mb-1" for="user_id">PIC</label>
                                                        <select class="form-control select2" name="user_id" id="user_id">
                                                            <option value="" selected disabled>Select PIC</option>
                                                            @foreach($kasir as $sup)
                                                            <option value="{{$sup->id}}" {{ old('user_id') == $sup->id ? 'selected' : '' }}>
                                                            {{$sup->name}} |  {{$sup->kode_user}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- batas --}}
                                                </div>
                                            </div>
                                            {{-- batas --}}
                                        </div>
                                        <div class="mt-4 flex justify-between">
                                            <div></div>
                                            <div class="form-group">
                                                <a class="px-5 btn btn-danger"
                                                    href="{{ route("goodsreceipt.index") }}">
                                                @lang('Cancel')</a>
                                                <button type="submit" class="px-5 btn btn-success">@lang('Save')  <i class="bi bi-check"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
        url: '{{ route('dropzone.upload') }}',
        maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, .png',
        maxFiles: 3,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
        },
        removedfile: function (file) {
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
        },
        init: function () {
            @if(isset($detail) && $detail->getMedia('pembelian'))
            var files = {!! json_encode($detail->getMedia('pembelian')) !!};
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
(function( $ ) {

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
            if (verified) {e.preventDefault();}
    });
});


$("#qty_diterima").on('input', function() {
  if ($('#qty_diterima').val() > $('#qty').val()) {
      var bla = $('#qty').val();
     $("#qty_diterima").val(bla);
    return false;
  }
});

})(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush

