@extends('layouts.app')
@section('title', 'Create Product')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
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
    {{--
    <div class="flex flex-row">
    </div>
    --}}
    <script src="{{  asset('js/jquery.min.js') }}"></script>
    <form id="product-form" action="{{ route('products.save') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
            </div>
            <div class="col-lg-12">
                @php
                $code = \Modules\Product\Entities\Product::generateCode();
                //echo $code;
                @endphp
                <div class="card">
                    <div class="row">
                    </div>
                    <div class="card-body">
                        <div class="flex relative py-2 mb-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-left">
                                <div class="bg-white pl-0 pr-3 font-semibold text-sm capitalize text-dark">Add Product Kategori <span class="px-1 hokkie font-semibold uppercase">{{ @$category->category_name }}</span></div>
                            </div>
                        </div>
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <input type="hidden" name="product_barcode_symbology" value="C128">
                        <input type="hidden" name="product_stock_alert" value="5">
                        <input type="hidden" name="product_quantity" value="1">
                        <input type="hidden" name="product_unit" value="Gram">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="border-right pr-3">
                                <div class="form-group">
                                    <label for="image">Product Images <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                    <div class="py-2">
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
                                    <div id="upload1" style="display: block !important;" class="align-items-center justify-content-center">
                                        <div  class="h-320 dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                            <div class="dz-message" data-dz-message>
                                                <i class="text-red-800 bi bi-cloud-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 bg-transparent">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_name">@lang('Product Name') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="product_name" required value="{{ old('product_name') }}">
                                        </div>


                                       <div class="form-group">
                                            <label for="product_note">Supplier</label>
                                         <select class="form-control select2" name="supplier_id" id="supplier_id" required>
                                                <option value="" selected disabled>Select Supplier</option>
                                                @foreach(\Modules\People\Entities\Supplier::all() as $sup)
                                                 <option value="{{$sup->id}}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                                    {{$sup->supplier_name}}</option>

                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="karat_id" id="karat_id" required>
                                                <option value="" selected disabled>Select Karat</option>
                                                @foreach(\Modules\Karat\Models\Karat::all() as $karat)
                                                <option value="{{ $karat->id }}">{{ $karat->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="round_id">@lang('Round') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="round_id" id="round_id" required>
                                                <option value="" selected disabled>Select Round</option>
                                                @foreach(\Modules\ItemRound\Models\ItemRound::all() as $round)
                                                <option value="{{ $round->id }}">{{ $round->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_code">Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="product_code" readonly value="{{ $code }}">
                                        </div>

                            <div x-data="passwordGenerator">
                                <button x-on:click="generatePassword">Generate Password</button>
                                <input type="text" x-model="password">
                            </div>



                                        <div class="form-group">
                                            <label for="shape_id">@lang('Shape') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="shape_id" id="shape_id" required>
                                                <option value="" selected disabled>Select Shape</option>
                                                @foreach(\Modules\ItemShape\Models\ItemShape::all() as $shape)
                                                <option value="{{ $shape->id }}">{{ $shape->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="certificate_id">@lang('Certificate') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="certificate_id" id="certificate_id" required>
                                                <option value="" selected disabled>Select Certificate</option>
                                                @foreach(\Modules\DiamondCertificate\Models\DiamondCertificate::all() as $certificate)
                                                <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
                                            <input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex relative py-1">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex row px-3 py-0">
                                    {{-- =================================================================================== --}}
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_emas">@lang('Berat') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_emas" type="number" class="form-control" name="berat_emas" required value="{{ old('berat_emas') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_accessories">@lang('Berat Accessories') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_accessories" type="number" class="form-control" name="berat_accessories" required value="{{ old('berat_accessories') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_label">@lang('Berat Label') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_label" type="number" class="form-control" name="berat_label" required value="{{ old('berat_label') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_total">@lang('Berat Total') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_total" type="number" class="form-control" name="berat_total" required value="{{ old('berat_total') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- =================================================================================== --}}
                                </div>
                                <div class="flex relative py-1">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Harga</span>
                                    </div>
                                </div>
                                <div class="flex row px-3 py-0">
                                    {{-- harga =================================================================================== --}}
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="product_price">@lang('Price') <span class="text-danger">*</span></label>
                                                <input id="product_price" type="text" class="form-control" name="product_price" required value="{{ old('product_price') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="product_cost">@lang('Cost') <span class="text-danger">*</span></label>
                                                <input id="product_cost" type="text" class="form-control" name="product_cost" required value="{{ old('product_cost') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="product_sale">@lang('Jual') <span class="text-danger">*</span></label>
                                                <input id="product_sale" type="text" class="form-control" name="product_sale" required value="{{ old('product_sale') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- =================================================================================== --}}
                                </div>
                                <div class="flex relative py-0">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Lokasi <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Lokasi Penyimpanan (Gudang /Rak etc."></i></span>
                                    </div>
                                </div>
                                {{-- =================================================================================== --}}
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gudang_id">@lang('Gudang') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="gudang_id" id="gudang_id" required>
                                                <option value="" selected disabled>Select Gudang</option>
                                                @foreach(\Modules\Gudang\Models\Gudang::all() as $gudang)
                                                 <option value="{{$gudang->id}}" {{ old('gudang_id') == $gudang->id ? 'selected' : '' }}>
                                                    {{$gudang->code}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                     <div class="form-group">
                                            <label for="etalase_id">@lang('Etalase') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="etalase_id" id="etalase_id" required>
                                                <option value="" selected disabled>Select Etalase</option>
                                                @foreach(\Modules\DataEtalase\Models\DataEtalase::all() as $et)
                                                 <option value="{{$et->id}}" {{ old('etalase_id') == $et->id ? 'selected' : '' }}>
                                                    {{$et->code}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                       <div class="form-group">
                                            <label for="baki_id">@lang('Baki') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="baki_id" id="baki_id" required>
                                                <option value="" selected disabled>Kode Baki</option>
                                                @foreach(\Modules\Baki\Models\Baki::all() as $bk)
                                                 <option value="{{$bk->id}}" {{ old('baki_id') == $bk->id ? 'selected' : '' }}>
                                                    {{$bk->code}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- =================================================================================== --}}
                                <div class="flex row px-3 py-0">
                                    <div class="p-0 col-lg-12">
                                        <div class="form-group">
                                            <label for="product_note">Note</label>
                                            <textarea name="product_note" id="product_note" rows="4 " class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between px-3 pb-2 border-bottom">
                        <div>
                        </div>
                        <div class="form-group">
                            <a class="px-5 btn btn-danger"
                                href="{{ route("products.index") }}">
                            @lang('Cancel')</a>
                            <button class="px-4 btn btn-primary">@lang('Create') @lang('Product') <i class="bi bi-check"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<x-library.select2 />
@endsection
@section('third_party_scripts')
<script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
@push('page_scripts')
<script type="text/javascript">
    $('#up1').change(function() {
        $('#upload2').toggle();
        $('#upload1').hide();
    });
    $('#up2').change(function() {
        $('#upload1').toggle();
        $('#upload2').hide();
    });
</script>
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
            @if(isset($product) && $product->getMedia('images'))
            var files = {!! json_encode($product->getMedia('images')) !!};
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
{{-- <script src="{{  asset('js/jquery.min.js') }}"></script> --}}
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
    jQuery.noConflict();
    (function( $ ) {
        $('#product_cost').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
        });
        $('#product_sale').maskMoney({
            prefix:'{{ settings()->currency->symbol }}',
            thousands:'{{ settings()->currency->thousand_separator }}',
            decimal:'{{ settings()->currency->decimal_separator }}',
            precision: 0,
        });
        $('#product_price').maskMoney({
            prefix:'{{ settings()->currency->symbol }}',
            thousands:'{{ settings()->currency->thousand_separator }}',
            decimal:'{{ settings()->currency->decimal_separator }}',
            precision: 0,
        });

})(jQuery);
</script>
@endpush