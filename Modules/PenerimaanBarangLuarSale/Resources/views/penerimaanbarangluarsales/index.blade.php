@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}}</li>
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
                            @can('create_penerimaanbarangluarsales')
                           <a href="{{ route(''.$module_name.'.create') }}"
                                id="Tambah"
                                data-toggle="tooltip"
                                 class="btn btn-outline-secondary px-3">
                                 <i class="bi bi-plus"></i>@lang('Add')&nbsp;Data
                                </a>
                                @endcan
                          <a href="{{ route(''.$module_name.'.insentif') }}"
                                data-toggle="tooltip"
                                 class="btn btn-outline-secondary px-3">
                                 <i class="bi bi-plus"></i>@lang('Insentif')
                                </a>

                        </div>
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 1%!important;">No</th>
                                    <th style="width: 7%!important;">Invoice</th>
                                    <th style="width: 7%!important;">Sales</th>
                                    <th style="width: 6%!important;">Detail Produk</th>
                                    <th style="width: 10%!important;">Nilai Produk</th>
                                    <th style="width: 6%!important;">Keterangan</th>
                                    <th style="width: 6%!important;" class="text-center">
                                        {{ __('Action') }}
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

                {data: 'no_barang_luar', name:  'no_barang_luar'},
                {data: 'sales', name:  'sales'},
                {data: 'detail_produk', name: 'detail_produk'},
                {data: 'nilai_produk', name: 'nilai_produk'},
                {data: 'keterangan', name: 'keterangan'},

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

</script>
@endpush