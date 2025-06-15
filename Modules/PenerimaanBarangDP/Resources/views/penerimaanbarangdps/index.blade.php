@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Penerimaan Barang DP</li>
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
                           <a href="{{ route(''.$module_name.'.create') }}"
                                id="Tambah"
                                data-toggle="tooltip"
                                 class="btn btn-outline-secondary px-3">
                                 <i class="bi bi-plus"></i>@lang('Add')&nbsp;Barang DP
                                </a>

                        </div>
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">

{{-- 
1.no barang
2.tanggal 
3.nama konsumen
4.cabang
5.nama produk
6.kadar
7.berat
8.nominal dp
9.pengambilan jatuh tempo
10.status
11.aksi 
--}}


                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                  <th style="width: 4%!important;">No</th>
<th class="text-center">{{ Label_Case('Invoice') }}</th>
<th class="text-center">{{ Label_Case('Konsumen') }}</th>
<th class="text-center">{{ Label_Case('Cabang') }}</th>
<th class="text-center">{{ Label_Case('Barang') }}</th>
<th class="text-center">{{ Label_Case('Nominal') }}</th>
<th class="text-center">{{ Label_Case('Pembayaran') }}</th>
<th style="width: 10%!important;" class="text-center">{{ __('Action') }}</th>
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

                {data: 'invoice', name: 'invoice'},
                {data: 'konsumen', name: 'konsumen'},
                {data: 'cabang', name: 'cabang'},
                {data: 'barang', name: 'barang'},
                {data: 'nominal', name: 'nominal'},
                {data: 'pembayaran', name: 'pembayaran'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })
        .buttons().remove()
        .container()
        .appendTo("#buttons");



    </script>

<script type="text/javascript">
var table = jQuery('#datatable').DataTable();
jQuery.noConflict();
(function( $ ) {
//group modal kategori
    $(document).on('click', '#edit_payment', function(e){
         e.preventDefault();
        $('.modal-dialog').addClass('modal-md');
        $('.modal-dialog').removeClass('modal-sm');
        $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp; Edit Pembayaran');

        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush