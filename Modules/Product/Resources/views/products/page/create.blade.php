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
.form-group {
margin-bottom: 0.5rem !important;
}
</style>
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
  
       <form id="FormTambah" action="{{ route("products.saveajax") }}" method="POST" enctype="multipart/form-data">
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

                      <div class="flex flex-row">
                            <x-library.alert />
                      </div>

                        <div class="flex relative py-2 mb-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-left">
                                <div class="bg-white pl-0 pr-3 font-semibold text-sm capitalize text-dark">Add  Kategori <span class="px-1 hokkie font-semibold uppercase">{{ @$mainkategori->name }}</span></div>
                            </div>
                        </div>
                        <input type="hidden" name="category_id" value="{{ $mainkategori->id }}">
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

                          <div class="flex flex-row grid grid-cols-2 gap-2">
                                
                                       <div class="form-group">
                                                <label for="group_id">@lang('Group')
                                                    <span class="text-danger">*</span>
                                                    <span class="small">Jenis Perhiasan</span>
                                                </label>
                                                <select class="form-control select2" name="group_id" id="group_id" required>
                                                    <option value="" selected disabled>Group</option>
                                                    @foreach(\Modules\Group\Models\Group::all() as $jp)
                                                    <option value="{{ $jp->id }}">{{ $jp->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>



                                    <div class="form-group">
                                            <label for="product_note">Model</label>
                                         <select class="form-control select2" name="produk_model" id="produk_model" required>
                                                <option value="" selected disabled>Select Model</option>
                                                     @foreach(\Modules\ProdukModel\Models\ProdukModel::all() as $sup)
                                                            <option value="{{$sup->id}}" {{ old('produk_model') == $sup->name ? 'selected' : '' }}>
                                                                {{$sup->name}}
                                                            </option>
                                                     @endforeach
                                            </select>
                                        </div>






                               
                             </div>

                                <div class="flex flex-row grid grid-cols-2 gap-2">
                                     
                                    <div class="col-span-2">
                                        <div class="flex flex-row gap-2">

                                         <div class="form-group w-60">
                                            <label for="product_note">Supplier</label>
                                         <select class="form-control select2" name="supplier_id" id="supplier_id" required>
                                                <option value="" selected disabled>Select Supplier</option>
                                                @foreach(\Modules\People\Entities\Supplier::all() as $sup)
                                                 <option value="{{$sup->id}}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                                    {{$sup->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                            <div class="form-group w-90">
                                                <label for="product_code">Code <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" id="code" class="form-control" name="product_code">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info relative rounded-l-none" id="generate-code">Chek</button>
                                                    </span>
                                                </div>
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text product_code_err"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

{{-- batas kategori form --}}

        {{--        @if(strpos($category->category_name, 'Mutiara') !== false)
                    @include('product::products.form.mutiara')
                @elseif(strpos($category->category_name, 'Berlian') !== false)
                  @include('product::products.form.berlian')

                 @elseif (\Illuminate\Support\Str::contains($category->category_name, ['Perak', 'Paladium']))
                   @include('product::products.form.perak')
                        @elseif(strpos($category->category_name, 'Logam Mulia') !== false)
                   @include('product::products.modal.lm')
                   @elseif (\Illuminate\Support\Str::contains($category->category_name, ['Emas', 'Perhiasan']))
                   @include('product::products.form.emas')
                    @else
                        @include('product::products.modal.all')
                    @endif --}}




{{-- end batas kategori --}}


                                <div class="flex relative py-1">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
                                        </span>
                                    </div>
                                </div>


              <div class="flex flex-row grid grid-cols-2 gap-2">
                          
                             <div class="form-group">
                                    <?php
                                    $field_name = 'berat_emas';
                                    $field_lable = label_case('Berat');
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
                                    value="{{old($field_name)}}"
                                    placeholder="{{ $field_placeholder }}">
                                    <span class="invalid feedback" role="alert">
                                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                                    </span>
                                </div>


                          <div class="form-group">
                                <?php
                                $field_name = 'berat_accessories';
                                $field_lable = label_case('berat_accessories');
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
                                value="{{old($field_name)}}"
                                placeholder="{{ $field_placeholder }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>
                            </div>

                              <div class="form-group">
                                            <?php
                                            $field_name = 'berat_label';
                                            $field_lable = label_case('berat_label');
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
                                            value="{{old($field_name)}}"
                                            placeholder="{{ $field_placeholder }}">
                                            <span class="invalid feedback" role="alert">
                                                <span class="text-danger error-text {{ $field_name }}_err"></span>
                                            </span>
                                        </div>


                                            <div class="form-group">
                                                    <?php
                                                    $field_name = 'berat_total';
                                                    $field_lable = label_case('berat_total');
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
                                                    value="{{old($field_name)}}"
                                                    placeholder="{{ $field_placeholder }}">
                                                    <span class="invalid feedback" role="alert">
                                                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                    </span>
                                                </div>

                             
                 </div>



                                <div class="flex relative py-1">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Harga</span>
                                    </div>
                                </div>


                             <div class="flex flex-row grid grid-cols-2 gap-2">
                                   


                                         <div class="form-group">
                                                <?php
                                                $field_name = 'product_cost';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control"
                                                type="text"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="{{ $field_placeholder }}"
                                                >
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>


                                       <div class="form-group">
                                                <?php
                                                $field_name = 'product_price';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control"
                                                type="text"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="{{ $field_placeholder }}"
                                                >
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>

                          

                                    
                                </div>
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
                        <div class="flex justify-between px-3 pb-2 border-bottom">
                            <div>
                            </div>
                            <div class="form-group">

                               <a href="{{ route('products.create-modal') }}"
                                    id="GroupKategori" class="px-4 py-2 btn btn-sm btn-outline-warning">
                                    @lang('Add Product')
                                </a>
                                <a class="px-5 btn btn-danger"
                                    href="{{ route("products.index") }}">
                                @lang('Cancel')</a>
                                <button id="SimpanTambah" type="button" class="px-4 btn btn-primary">@lang('Save')  <i class="bi bi-check"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


<div id="ModalKategori" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="ModalHeaderkategori"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModalContentKategori"> </div>
         <div class="modal-footer" id="ModalFooterKategori"></div>

        </div>
    </div>
</div>


<div id="ModalGroupKategori" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="ModalHeaderGroupkategori"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModalContentGroupKategori"> </div>
         <div class="modal-footer" id="ModalFooterGroupKategori"></div>

        </div>
    </div>
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


        
       $('#nominal').change(function() {
          toastr.success('Margin Nominal dipilih');
            $('#m2').toggle();
            $('#m1').hide();
        });

        $('#persentase').change(function() {
           toastr.success('margin Persentase dipilih');
            $('#m1').toggle();
            $('#m2').hide();
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
(function($) {
    $('#product_cost').maskMoney({
        prefix: 'Rp ',
        thousands: '.',
        decimal: ',',
        precision: 0
    });
    $('#product_sale').maskMoney({
        prefix: '{{ settings()->currency->symbol }}',
        thousands: '{{ settings()->currency->thousand_separator }}',
        decimal: '{{ settings()->currency->decimal_separator }}',
        precision: 0,
    });
    $('#product_price').maskMoney({
        prefix: '{{ settings()->currency->symbol }}',
        thousands: '{{ settings()->currency->thousand_separator }}',
        decimal: '{{ settings()->currency->decimal_separator }}',
        precision: 0,
    });
    $('#generate-code').click(function() {
        var group = $('#group_id').val();
        //alert(group);
        $(this).prop('disabled', true);
        $(this).addClass('loading');
        $.ajax({
            url: '{{ route('products.code_generate') }}', 
            type: 'POST',
            data: { group: group },
            dataType: 'json',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.code === '0') {
                    $('#code').prop('readonly', true);
                    $('#code').val('Group harus di isi..!!');
                } else {
                    $('#code').val(response.code);
                }
                console.log(response);
            },
            complete: function() {
                $('#generate-code').prop('disabled', false);
                $('#generate-code').removeClass('loading');
            }
        });
    });




//group modal kategori

  $(document).on('click', '#GroupKategori', function(e){
         e.preventDefault();
          $('#ModalBacktoKategori').modal('hide');
          $("#ModalBacktoKategori").trigger("reset");
               $('#ModalKategori').modal('hide');
          $('#ModalKategori').modal('hide');
          $("#ModalKategori").trigger("reset");
         if($(this).attr('id') == 'GroupKategori')
         {

            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-xl');
            $('#ModalHeaderGroupkategori').html('<i class="bi bi-grid-fill"></i> &nbspGroup {{ Label_case(' Kategori') }}');
        }
        $('#ModalContentGroupKategori').load($(this).attr('href'));
        $('#ModalGroupKategori').modal('show');
        $('#ModalGroupKategori').modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                });
    });





//modal detail kategori

    $(document).on('click', '#openModalKategori', function(e){
          e.preventDefault();

           $('#ModalBacktoKategori').modal('hide');
            $("#ModalBacktoKategori").trigger("reset");
            $('#ModalGroupKategori').modal('hide');
            $("#ModalGroupKategori").trigger("reset");
             var dataURL = $(this).attr('data-href');
            //alert(dataURL);
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-xl');
            $('#ModalContentKategori').load($(this).attr('href'));
            $('#ModalHeaderkategori').html('<i class="bi bi-grid-fill"></i> &nbspKategori {{ Label_case(' Products') }}');
            $('#ModalKategori').modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                });
           });



    function Tambah()
        {

            $.ajax({
                url: $('#FormTambah').attr('action'),
                type: "POST",
                data: new FormData($('#FormTambah')[0]),
                processData: false,
                contentType: false,
                cache: false,
                mimeType:'multipart/form-data',
                dataType:'json',
                success: function(data) {
                    console.log(data.error)
                    if($.isEmptyObject(data.error)){
                        $('#ResponseInput').html(data.success);
                        console.log(data.produk);
                        var value = data.produk;
                        Livewire.emit('addProduk', value);
                        console.log(value);
                        $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                            setTimeout(function() {
                              window.location.href = "{{ route('purchase.type', ['type' => 'toko']) }}";
                            }, 2000);
                    }else{
                        printErrorMsg(data.error);
                         $(this).closest('form').trigger("reset");
                    }
                }
            });
        }
        function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {
                console.log(key);
                $('#'+key+'').addClass("");
                $('#'+key+'').addClass("is-invalid");
                $('.'+key+'_err').text(value);
            });


        }


          $('#SimpanTambah').click(function(e){
                e.preventDefault();
                Tambah();
            });
            $('#FormTambah').submit(function(e){
                e.preventDefault();
                Tambah();
            });


})(jQuery);

</script>

    @endpush