@extends('layouts.app')

@section('title', 'Penjualan Unit')

@section('third_party_stylesheets')

@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Penjualan Unit</li>
    </ol>
@endsection

@push('page_css')
    <style type="text/css">
        .c-main {
            flex-basis: auto;
            flex-shrink: 0;
            flex-grow: 1;
            min-width: 0;
            padding-top: 0.3rem;
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid">

        {{-- TABLE LAPORAN PENJUALAN UNIT --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex justify-between py-1 border-bottom">
                            <div>
                                <h1 class="text-lg font-semibold">Laporan Penjualan Unit</h1>
                            </div>
                            <div id="buttons"></div>
                        </div>
                        <div class="table-responsive mt-1">
                            <table id="salesUnitTable" style="width: 100%"
                                class="table table-striped table-hover table-bordered table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karat</th>
                                        <th>Total Berat</th>
                                        <th>Total Produk</th>
                                        <th>Sales</th>
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
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>

    <script type="text/javascript">
        $('#salesUnitTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                responsive: true,
                lengthChange: true,
                searching: true,
                "oLanguage": {
                    "sSearch": "<i class='bi bi-search'></i> {{ __('labels.table.search') }} : ",
                    "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per {{ __('labels.table.page') }} ",
                    "sInfo": "{{ __('labels.table.showing') }} _START_ s/d _END_ {{ __('labels.table.from') }} <b>_TOTAL_ data</b>",
                    "sInfoFiltered": "(filter {{ __('labels.table.from') }} _MAX_ total data)",
                    "sZeroRecords": "{{ __('labels.table.not_found') }}",
                    "sEmptyTable": "{{ __('labels.table.empty') }}",
                    "sLoadingRecords": "Harap Tunggu...",
                    "oPaginate": {
                        "sPrevious": "{{ __('labels.table.prev') }}",
                        "sNext": "{{ __('labels.table.next') }}"
                    }
                },
                "aaSorting": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
                "sPaginationType": "simple_numbers",
                ajax: '{{ route('sales-unit-report-data.index') }}',
                dom: 'Blrtip',
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
                    {
                        data: 'karat_name',
                        name: 'karats.name'
                    },
                    {
                        data: 'total_berat',
                        name: 'total_berat',
                        searchable: false
                    },
                    {
                        data: 'total_produk',
                        name: 'total_produk',
                        searchable: false
                    },
                    {
                        data: 'total_penjualan',
                        name: 'total_penjualan',
                        searchable: false
                    },
                    // KAYANYA BELUM PERLU ACTION
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

@endpush
