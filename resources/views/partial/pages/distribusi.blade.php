<div class="flex gap-1">
  <div class="w-3/4">


@can('dashboard_distribusi')

<div class="flex flex-row grid grid-cols-3 gap-2 mt-1">  
<div class="card border-0">
    <div  onclick="location.href='{{ route("home.distribusi", ['status'=>'inprogress']) }}';" class="cursor-pointer h-zoom hover:scale-125 transition-all duration-500 hover:bg-primary card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>


@php
   
@endphp

            <div class="text-value text-primary text-lg">{{ \Modules\DistribusiToko\Models\DistribusiToko::inprogress()->count() }}</div>
            <div class="text-muted text-uppercase font-weight-bold small">
            In Progress
            </div>

        </div>
    </div>
</div>

<div class="card border-0">
    <div onclick="location.href='{{ route("home.distribusi", ['status'=>'completed']) }}';" class="cursor-pointer h-zoom hover:scale-125 transition-all duration-500 hover:bg-primary card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-success">{{ \Modules\DistribusiToko\Models\DistribusiToko::completed()->count() }}</div>
            <div class="text-muted text-uppercase font-weight-bold small">
           Completed
            </div>

        </div>
    </div>
</div>

<div class="card border-0">
    <div onclick="location.href='{{ route("home.distribusi", ['status'=>'retur']) }}';" class="cursor-pointer h-zoom hover:scale-125 transition-all duration-500 hover:bg-primary card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-warning">{{ \Modules\DistribusiToko\Models\DistribusiToko::retur()->count() }}</div>
            <div class="text-muted text-uppercase font-weight-bold small">
           Retur
            </div>

        </div>
    </div>
</div>



</div>


@endcan


@can('access_distribusi')

  <div class="card">
    <div class="card-body">
        <div class="flex justify-between py-1 border-bottom">
            <div>
             <span class="font-semibold text-gray-600 text-lg">{{ ucfirst('Distribusi') }}</span> 
            </div>
            <div id="buttons">
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th style="width: 6%!important;">No</th>
                        <th>Date</th>
                        <th>No Invoice</th>
                        <th style="width: 15%!important;" class="text-center">{{ __('Cabang') }}</th>
                        <th>{{ __('Karat') }}</th>
                        <th style="width: 16%!important;" class="text-center">
                            {{ __('Status') }}
                        </th>
                        
                        
                        <th style="width: 14%!important;" class="text-center">
                            {{ __('Action') }}
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

<hr>




    </div>
</div>


@endcan


  </div>



  <div class="w-1/4 card">
 @include('partial.pages.user')
  </div>
</div>


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
table.dataTable {
    clear: both;
    margin-top: 0.3rem !important;
    margin-bottom: 0.3rem !important;
    max-width: none !important;
    border-collapse: separate !important;
    border-spacing: 0;
}

.table th, .table td {
    padding: 0.3rem !important;
    vertical-align: top;
    border-top: 1px solid;
    border-top-color: #d8dbe0;
}

div.dataTables_wrapper div.dataTables_paginate {
    margin: 0;
    white-space: nowrap;
    text-align: right;
    font-size: 0.7rem !important;
}

</style>
@endsection




<x-library.datatable />
@push('page_scripts')
@can('access_distribusi')

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
             ajax: "{{ route("distribusitoko.index_data_table", ['status'=>$status]) }}",
            dom: 'Blfrtip',
            buttons: [

                'excel',
                'pdf',
                'print'
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'date', name: 'date'},
                {data: 'no_invoice', name: 'no_invoice'},
                {data: 'cabang', name: 'cabang'},
                {data: 'karat', name: 'karat'},
                {data: 'status', name: 'status'},
              

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
        $('#datatable_completed').DataTable({
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
            ajax: '{{ route("distribusitoko.index_data_complete") }}',
            dom: 'Blfrtip',
            buttons: [

                'excel',
                'pdf',
                'print'
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'date', name: 'date'},
                {data: 'no_invoice', name: 'no_invoice'},
                              {data: 'karat', name: 'karat'},
                {data: 'status', name: 'status'},
              

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
        .appendTo("#buttons_completed");



    </script>

@endcan

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
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case('Produk') }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case('Produk') }}');
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
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Approve Distribusi');
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

