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

        @can('show_total_stats')
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                                <i class="bi bi-speedometer2 font-2xl"></i>
                            </div>
                            <div>
                                {{-- <div class="text-value text-primary">{{ format_currency($totalGoldSales) }}</div> --}}
                                <div class="text-value text-primary">{{ $formattedStockWeight }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('Total Weight')
                                </div>
                                {{-- <p class="text-muted font-weight-bold small">{{ $todayDate->format("d/m/Y") }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                                <i class="bi bi-box font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-warning">{{ $stockQuantity }} Pcs</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('Total Quantity')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                                <i class="bi bi-cash font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-success">{{ $formattedNilaiAset }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('Asset Value')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                                <i class="bi bi-cash font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-info">{{ $formattedPotensiAset }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('Asset Potential')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endcan

        {{-- TABLE LAPORAN STOK --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex justify-between py-1 border-bottom">
                            <div>
                                <h1 class="text-lg font-semibold">Laporan Stok</h1>
                            </div>
                            <div id="buttons"></div>
                        </div>
                        <div class="table-responsive mt-1">
                            <table id="stockReportTable" style="width: 100%"
                                class="table table-striped table-hover table-bordered table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Kategori</th>
                                        <th>Nama Karat</th>
                                        <th>Total Berat</th>
                                        <th>Total Produk</th>
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
        $('#stockReportTable').DataTable({
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
                ajax: '{{ route('stock-report-data.index') }}',
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
                        data: 'category_code',
                        name: 'category_code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'total_berat',
                        name: 'total_berat'
                    },
                    {
                        data: 'total_produk',
                        name: 'total_produk'
                    },
                ]
            })
            .buttons()
            .container()
            .appendTo("#buttons");
    </script>

@endpush
