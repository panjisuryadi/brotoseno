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
<?php  
$jp = \Modules\KategoriProduk\Models\KategoriProduk::all();
?>  
    @foreach($jp as $category)
    <div class="no-underline cursor-pointer px-0 py-2 w-full">
           <a class="w-full no-underline hover:no-underline" id="openModalKategori"
                href="{{ route('products.view_by_kategori',$category->slug) }}" >
        <div class="justify-center items-center border-2 border-gray-400 bg-white  px-2 py-3 rounded-lg transform transition duration-500 hover:scale-110">
            <div class="justify-center text-center items-center">
                <?php
                if ($category->image) {
                $image = asset(imageUrl() . $category->image);
                }else{
                $image = asset('images/logo.png');
                }
                ?>
                <img id="default_1" src="{{ $image }}" alt="images"
                class="h-16 w-16 object-contain mx-auto"/>
            </div>
            <div
            class="font-semibold text-gray-600 no-underline hover:text-red-600 leading-tight">
            {{ $category->name }}
            </div>
        </div>
        </a>
    </div>


    @endforeach
</div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between pb-3 border-bottom">
                        <div> 
                            <i class="bi bi-plus"></i> &nbsp; <span class="text-lg font-semibold"> List Produk </span>
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

                      <th style="width: 10%!important;" class="text-center">{{ Label_case('Qr Code') }}</th>


                      <th style="width: 13%!important;" class="text-center">{{ Label_case('Status') }}</th>

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



@endsection
<x-library.datatable />
@push('page_scripts')

<script type="text/javascript">
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
        ajax: '{{ route("$module_name.index_data") }}',
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
        },{
            data: 'tracking',
            name: 'tracking'
        },{
            data: 'status',
            name: 'status'
        },
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