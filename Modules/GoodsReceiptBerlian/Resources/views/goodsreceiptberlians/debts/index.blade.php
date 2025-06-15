@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

@endsection
@push('page_css')
<style type="text/css">
    
table.dataTable>thead .sorting, table.dataTable>thead .sorting_asc, table.dataTable>thead .sorting_desc, table.dataTable>thead .sorting_asc_disabled, table.dataTable>thead .sorting_desc_disabled {
    text-align: left !important;

}
</style>
@endpush
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}}</li>
    <li class="breadcrumb-item active"> @lang('Goods Receipt Debts') </li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                          <h1> @lang('Goods Receipt Debts')</h1>

                        </div>
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-striped table-hover table-bordered table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 3%!important;">No</th>
                                    <th style="width: 22%!important;"  class="text-left">{{ __('Date') }}</th>
                                 
                                    <th style="width: 18%!important;"  class="text-left">{{ __('Berat') }} / {{ __('Karat') }}</th>
                                    <th style="width: 19%!important;" class="text-left">{{ __('Supplier') }}</th>
                                    <th class="text-center">{{ __('Pembayaran') }}
                                    </th>
                                    <th style="width:23%!important;" class="text-center">{{ __('Action') }}
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
            ajax: '{{ route("$module_name.debts_data") }}',
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
                {data: 'berat', name: 'berat'},
                {data: 'supplier', name: 'supplier'},
                {data: 'pembayaran', name: 'pembayaran'},


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
var table = jQuery('#datatable').DataTable();
jQuery.noConflict();
(function( $ ) {
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
            // $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-sm');
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

    $(document).on('click', '#edit_status', function(e){
         e.preventDefault();
        $('.modal-dialog').addClass('modal-md');
        $('.modal-dialog').removeClass('modal-sm');
        $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp; Edit Status Pembelian');

        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });


})(jQuery);
</script>
@endpush