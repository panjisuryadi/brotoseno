@extends('layouts.app')

@section('title', 'Stok')

@section('third_party_stylesheets')

@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stok</li>
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
        <div class="card">
            <div class="card-body">
                <div class="row">

                    {{-- UBAH KE col-md-6 KALO TABLE LAPORAN SALES DI SHOW --}}
                    <div class="col-12">
                        {{-- <h2 class="mb-4">Laporan Stok</h2> --}}
                        <div class="pb-3"> 
                            <span class="text-lg font-semibold">Laporan Stok</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="stockReportTable1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karat</th>
                                        <th>Total Berat</th>
                                        <th>Total Produk</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    {{-- TABLE LAPORAN SALESNYA DI HIDE DULU --}}
                    {{-- <div class="col-md-6">
                        <h2 class="mb-4">Laporan Sales</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="stockReportTable2">
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
                    </div> --}}

                </div>
            </div>
        </div>

    </div>

@endsection

@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <!-- Bootstrap JS (with Popper) – CDN version -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AHR5oKn06PWzGk+E9Y1kCfmhktbZ5d9+8wCjUY8H7Sk/9kccB+ApPBALSczF+" crossorigin="anonymous">
    </script> -->

    <script>
        $(document).ready(function() {
            $('#stockReportTable1').DataTable({
                processing: true,
                serverSide: true,
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
                ajax: '{{ route('stock-report-stock.index') }}',
                dom: 'lrtip',
                columns: [{ // ini digunakan untuk menampilkan urutan data sesuai dengan pagination, didapat dari addIndexColum() pada controller yang ada DataTablesnya
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
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
                    // KAYANYA BELUM PERLU ACTION
                    // { 
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // }
                ]
            });

            $('#stockReportTable2').DataTable({
                processing: true,
                serverSide: true,
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
                ajax: '{{ route('stock-report-sales.index') }}',
                dom: 'lrtip',
                columns: [{ // ini digunakan untuk menampilkan urutan data sesuai dengan pagination, didapat dari addIndexColum() pada controller yang ada DataTablesnya
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
            });
        });
    </script>
@endpush
