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


.loading {
    pointer-events: none;
    opacity: 0.6;
}

.loading:after {
    content: '';
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid #fff;
    border-top-color: transparent;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
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


                    @if(strpos($category->category_name, 'Mutiara') !== false)
                    @include('product::products.form.mutiara')
                    @elseif(strpos($category->category_name, 'Berlian') !== false)
                  @include('product::products.form.berlian')
                    @elseif (\Illuminate\Support\Str::contains($category->category_name, ['Perak', 'Paladium']))
                   @include('product::products.form.perak')
                    @elseif(strpos($category->category_name, 'Logam Mulia') !== false)
                   @include('product::products.modal.lm')
                     @elseif (strpos($category->category_name, 'Emas') !== false)
                   @include('product::products.form.emas')
                    @else
                     @include('product::products.modal.all')
                    @endif

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

$('#generate-code').click(function() {

    $(this).prop('disabled', true);
    // $('#generate-code').html('');
    $(this).addClass('loading');
    $.ajax({
        url: '{{ route('products.code_generate') }}',
        type: 'POST',
        dataType: 'json',
        headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
               },
        success: function(response) {
              console.log(response);
              $('#code').val(response.code);
            },
        complete: function() {
            $('#generate-code').prop('disabled', false);
            $('#generate-code').removeClass('loading');
        }
    });
});




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