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


<div class=" px-0 py-2 grid grid-cols-4 gap-4 m-2 text-center no-underline">

</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between pb-3 border-bottom">
                        <div> 
                            <i class="bi bi-plus"></i> &nbsp; <span class="text-lg font-semibold"> List All Produk</span>
                        </div>
                        <div id="buttons"></div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">NO</th>
                                    <th style="width: 9%!important;">{{ Label_case('image') }}</th>
                                    <th>{{ Label_case('product') }}</th>
                                   
                                    <th style="width: 14%!important;" class="text-center">{{ Label_case('Karat / Harga') }}</th>


                            <th style="width: 11%!important;" class="text-center">{{ Label_case('Date') }}</th>

                      <!-- <th style="width: 10%!important;" class="text-center">{{ Label_case('Qr Code') }}</th> -->


                      <th style="width: 13%!important;" class="text-center">Baki</th>
                      <th style="width: 13%!important;" class="text-center">QR</th>

                 <th style="width: 18%!important;" class="text-center">
                                        Action
                                    </th>
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
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Add Product Tanpa Nota</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/products_insert" method="post">
                    @csrf
                    <div class="px-0 py-2">
                                @php
                                $number = 0;
                                @endphp
                                <div class="col-span-2 px-2">
                                    <div class="flex flex-row grid grid-cols-2 gap-1">
                                        <div class="form-group">
                                            <label for="product_category">Product Category</label>
                                            <select name="new_product_category_id" id="product_category" class="form-control @error('new_product.product_category_id') is-invalid @enderror">
                                            <option value="">Semua Produk</option>

                                                @foreach($product_categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                            <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
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
                                            <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}">
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
                                            <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}">
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
                                                <input type="text" id="{{ $field_id }}" name="new_product_code_id" class="form-control @error($field_name) is-invalid @enderror" readonly>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info relative rounded-l-none" onclick="gencode({{ $number }});" type="button">Check</button>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- ///batas --}}
                                    <div class="flex flex-row grid grid-cols-4 gap-2">
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.accessories_weight';
                                        $field_id   = 'acc_'.$number;
                                        $field_lable = label_case('Accessories');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                        <input class="form-control @error($field_name) is-invalid @enderror"
                                        type="number"
                                        name="{{ $field_name }}"
                                        step="0.001"
                                        id="{{ $field_id }}"
                                        onkeyup="getotal({{ $number }});"
                                        id="{{ $field_name }}"
                                        placeholder="{{ $field_placeholder }}"
                                        min="0"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.tag_weight';
                                        $field_id   = 'tag_'.$number;
                                        $field_lable = label_case('tag');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                        <input class="form-control @error($field_name) is-invalid @enderror"
                                        type="number"
                                        onkeyup="getotal( {{ $number }} );"
                                        min="0" step="0.001"
                                        id="{{ $field_id }}"
                                        placeholder="{{ $field_placeholder }}">
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.gold_weight';
                                        $field_id   = 'emas_'.$number;
                                        $field_lable = label_case('emas');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                        <input class="form-control @error($field_name) is-invalid @enderror"
                                        type="number"
                                        name="{{ $field_name }}"
                                        min="0" step="0.001"
                                        id="{{ $field_id }}"
                                        onkeyup="getotal( {{ $number}} );"
                                        placeholder="{{ $field_placeholder }}">
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.total_weight';
                                        $field_id   = 'total_'.$number;
                                        $field_lable = label_case('Total');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                        <input class="form-control"
                                        type="number"
                                        name="{{ $field_name }}"
                                        id="{{ $field_id }}"
                                        onkeyup="getotal({{ $number }});"
                                        placeholder="{{ $field_placeholder }}"
                                        readonly>
                                    </div>
                                </div>
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
            $("#code_"+number).val('');
            let rand    = Math.floor(Math.random() * 1000);
            let group   = $('#group_' + number).find('option:selected').text();
            group       = group.substring(0, 1);
            let karat   = $('#karat_' + number).find('option:selected').text();
            karat       = karat.split('|')[0]?.trim();
            let date    = new Date();
            let formattedDate = ("0" + date.getDate()).slice(-2) + ("0" + (date.getMonth() + 1)).slice(-2) + date.getFullYear().toString().slice(-2);
            let code    = group+karat+formattedDate+rand;
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
        ajax: '/products_data/0',
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
        }, {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'karat',
            name: 'karat'
        }, {
            data: 'created_at',
            name: 'created_at'
        },
        // {
        //     data: 'tracking',
        //     name: 'tracking'
        // },
        {
            data: 'baki',
            name: 'baki'
        },
        {
            data: 'tracking',
            name: 'tracking'
        },
        // {
        //     data: 'status',
        //     name: 'status'
        // },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
        ]
    })
    .buttons()
    .container()
    .appendTo("#buttons");


</script>
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
        $('#ModalGue').modal('show');
    });


})(jQuery);
</script>
<script language="JavaScript">
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