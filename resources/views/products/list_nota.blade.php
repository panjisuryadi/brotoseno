@extends('layouts.app')
@section('title', 'Products')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style type="text/css">
    div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: 220px !important;
    }
    div.dataTables_wrapper div.dataTables_length select {
    width: 70px !important;
    display: inline-block;
    }
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
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="btn-group">
                        <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#createModal">
                            Add Product <i class="bi bi-plus"></i>
                        </a>
                    </div>
                    <div class="flex justify-between pb-3 border-bottom">
                        <div> 
                            <i class="bi bi-plus"></i> &nbsp; <span class="text-lg font-semibold"> List Produk Satuan</span>
                        </div>
                        <div id="buttons"></div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">NO</th>
                                    <th style="width: 15%!important;">Image</th>
                                    <th style="width: 15%!important;">Product</th>
                                    <!-- <th style="width: 15%!important;" class="text-center">Harga Beli</th> -->
                                    <th style="width: 10%!important;" class="text-center">Berat</th>
                                    <th style="width: 15%!important;" class="text-center">Code</th>
                                    <th style="width: 10%!important;" class="text-center">QR</th>
                                    <th style="width: 15%!important;" class="text-center">Keterangan</th>
                                    <th style="width: 15%!important;" class="text-center">Date</th>
                                    <th style="width: 15%!important;" class="text-center">#</th>
                                    
                 <!-- <th style="width: 18%!important;" class="text-center">
                                        Action
                                    </th> -->
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Add Product Satuan</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/products_insert_nota" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="webcam" id="hasilcapture">
                    <div class="px-0 py-2">
                                @php
                                $number = 0;
                                @endphp
                                <div class="col-span-2 px-2">
                                    <div class="flex flex-row grid grid-cols-2 gap-1">
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
                                        
                                        <!-- </div> -->
                                        <div class="form-group">
                                            <?php
                                            $field_id   = 'product_category_'.$number;
                                            ?>
                                            <label for="product_category">Product Category</label>
                                            <select name="new_product_category_id" id="{{$field_id}}" class="form-control @error('new_product.product_category_id') is-invalid @enderror" required>
                                            <option value="">Semua Produk</option>

                                                @foreach($product_categories as $category)
                                                    <option value="{{ $category->id }}" code="{{ $category->category_code }}">{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'new_product.model_id';
                                            $field_lable = label_case('model');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                            <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" required>
                                                <option value="" selected disabled>Pilih Model</option>
                                                @foreach($models as $model)
                                                <option value="{{$model->id}}">
                                                    {{$model->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'new_product.karat_id';
                                            $field_id   = 'karat_'.$number;
                                            $field_lable = label_case('karat');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">@lang('Karat') <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}" required>
                                                @foreach($dataKarat as $karat)
                                                    <option value="{{ $karat->id }}" >{{ $karat->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'new_product.group_id';
                                            $field_id   = 'group_'.$number;
                                            $field_lable = label_case('group');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">@lang($field_lable)
                                                <span class="text-danger">*</span>
                                                <span class="small">Jenis Perhiasan</span>
                                            </label>
                                            <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}" required>
                                                <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                                @foreach($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div> 

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'new_product.code';
                                            $field_id   = 'code_'.$number;
                                            $field_lable = label_case('code');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="{{ $field_id }}" name="new_product_code_id" class="form-control @error($field_name) is-invalid @enderror" readonly required>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info relative rounded-l-none" onclick="gencode({{ $number }});" type="button">Check</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'new_product.keterangan';
                                            $field_id   = 'keterangan_'.$number;
                                            $field_lable = label_case('keterangan');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                            <textarea id="{{ $field_id }}" name="new_product_keterangan" class="form-control"></textarea>
                                            <!-- <div class="input-group">
                                            </div> -->
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'new_product.berat';
                                            $field_id   = 'berat_'.$number;
                                            $field_lable = label_case('berat');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_lable }} (gram)<span class="text-danger">*</span></label>
                                            <input type="text" id="{{ $field_id }}" name="new_product_berat" class="form-control " required>
                                            <!-- <div class="input-group">
                                            </div> -->
                                        </div>

                                    </div>

                                    {{-- ///batas --}}
                                    
                                </div>
                                <button class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<x-library.datatable />
@section('third_party_scripts')
<script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
@push('page_scripts')
<script src="{{  asset('js/jquery.min.js') }}"></script>

<script type="text/javascript">
    jQuery.noConflict();

    function getotal(number){
            $('#total_' + number).val(0);
            let acc     = parseInt($('#acc_' + number).val());
            console.log(acc);
            let tag     = parseInt($('#tag_' + number).val());
            let emas    = parseInt($('#emas_' + number).val());
            let total   = acc + tag + emas;
            $('#total_' + number).val(total);
        }

        function gencode(number){
            console.log(number);
            let rand    = Math.floor(Math.random() * 1000);
            let group   = $('#group_' + number).find('option:selected').text();
            group       = group.substring(0, 1);
            let categoryCode = $('#product_category_' + number).find('option:selected').attr('code');

            let karat   = $('#karat_' + number).find('option:selected').text();
            karat       = karat.split('|')[0]?.trim();
            let date    = new Date();
            let formattedDate = ("0" + date.getDate()).slice(-2) + ("0" + (date.getMonth() + 1)).slice(-2) + date.getFullYear().toString().slice(-2);
            let code    = categoryCode+karat+formattedDate+rand;
            $("#code_"+number).val(code);
        }
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        lengthChange: true,
        searching: true,
        "oLanguage": {
            "sSearch": "<i class='bi bi-search'></i> {{ __("labels.table.search") }} : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per {{ __("labels.table.page") }} ",
            "sInfo": "{{ __("labels.table.showing") }} _START_ s/d _END_ {{ __("labels.table.from") }} <b>_TOTAL_ data</b>",
            "sInfoFiltered": "(filter {{ __("labels.table.from") }} _MAX_ total data)",
            "sZeroRecords": "{{ __("labels.table.not_found") }}",
            "sEmptyTable": "{{ __("labels.table.empty") }}",
            "sLoadingRecords": "Harap Tunggu...",
            "oPaginate": {
                "sPrevious": "{{ __("labels.table.prev") }}",
                "sNext": "{{ __("labels.table.next") }}"
            }
        },

        "aaSorting": [[ 0, "desc" ]],
        "columnDefs": [
        {
            "targets": 'no-sort',
            "orderable": false,
        }
        ],
        "sPaginationType": "simple_numbers",
        // ajax: '{{ route("$module_name.index_data") }}',
        ajax: '/products_datanota',
        dom: 'Blfrtip',
        buttons: [
            {
                    extend: 'excel',
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5,6 ]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5,6 ]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5,6 ]
                    }
                }
        ],
        columns: [{
            "data": 'id',
            "sortable": false,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            data: 'product_image',
            name: 'product_image'
        }, 
        {
            data: 'product_name',
            name: 'product_name'
        },
        // {
        //     data: 'karat',
        //     name: 'karat'
        // },
        {
            data: 'berat_emas',
            name: 'berat_emas'
        },
        {
            data: 'code',
            name: 'code'
        },
        {
            data: 'qr',
            name: 'qr'
        },
        {
            data: 'keterangan',
            name: 'keterangan'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'delete',
            name: 'delete'
        },
        // {
        //     data: 'tracking',
        //     name: 'tracking'
        // },
        // {
        //     data: 'status',
        //     name: 'status'
        // },
        // {
        //     data: 'action',
        //     name: 'action',
        //     orderable: false,
        //     searchable: false
        // }
        ]
    })
    .buttons()
    .container()
    .appendTo("#buttons");


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">

jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah,#QrCode,#Show, #Edit', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }

         if($(this).attr('id') == 'QrCode')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Cetak QR Code');
        } 

         if($(this).attr('id') == 'Show')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Detail');
        }
        
        $('#ModalContent').load($(this).attr('href'));
        // var myModalEl = document.getElementById('ModalGue');
        // var modal = new bootstrap.Modal(myModalEl);
        // modal.show();
        $('#ModalGue').modal('show');
    });


})(jQuery);
</script>
<script language="JavaScript">
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
            console.log('uploaded');
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
    $('#up1').change(function() {
        $('#upload2').toggle();
        $('#upload1').hide();
    });
    $('#up2').change(function() {
        $('#upload1').toggle();
        $('#upload2').hide();
    });
    function configure(){
        Webcam.set({
            width: 340,
            height: 230,
            autoplay: false,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false
        });
        Webcam.attach( '#camera' );
        $("#camera").attr("style", "display:block")
        $('#hasilGambar').addClass('d-none');
        $('#Start').addClass('d-none');
        $('#snap').removeClass('d-none');
    }
    // preload shutter audio clip
    var shutter = new Audio();
    shutter.autoplay = false;
    shutter.src = navigator.userAgent.match(/Firefox/) ? asset('js/webcamjs/shutter.ogg') : asset('js/webcamjs/shutter.mp3');

    function take_snapshot() {
        console.log('here');
        // play sound effect
        shutter.play();
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            $("#camera").attr("style", "display:none")
            $('#hasilGambar').removeClass('d-none').delay(5000);
            document.getElementById('hasilGambar').innerHTML =
                '<img class="border-2 border-dashed border-yellow-600 rounded-xl" id="imageprev" src="'+data_uri+'"/><span class="absolute bottom-1 text-white right-4">Capture Sukses..!! </span>';
            $('#snap').addClass('d-none');
            $('#Start').removeClass('d-none');
        });
        Webcam.reset();
    }

    function reset() {
            Webcam.reset();
                alert('off');
    }

    function saveSnap(){
        // Get base64 value from <img id='imageprev'> source
        var base64image =  document.getElementById("imageprev").src;

            Webcam.upload( base64image, 'upload.php', function(code, text) {
                console.log('Save successfully');
                //console.log(text);
        });

    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush