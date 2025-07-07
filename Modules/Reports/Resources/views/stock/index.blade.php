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
                                <div class="text-value text-primary">{{ $formattedStockWeight }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('Total Weight')
                                </div>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- JUDUL TABLE --}}
                        <div class="flex justify-between py-1 border-bottom">
                            <div>
                                <h1 class="text-lg font-semibold">Laporan Stok</h1>
                            </div>
                            <div id="buttons"></div>
                        </div>

                        {{-- TABLE REPORT STOK --}}
                        <div class="table-responsive mt-1">

                            {{-- BUTTON FILTER --}}
                            <div class="btn-group mb-1" style="float: right; z-index: 100;">
                                <a href="#" class="px-3 btn btn-primary" data-toggle="modal"
                                    data-target="#createModal">
                                    Add Filter <i class="bi bi-filter"></i>
                                </a>
                            </div>

                            <table id="stockReportTable" style="width: 100%;"
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

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">

                {{-- MODAL HEADER --}}
                <div class="modal-header">
                    <h3 class="modal-title text-lg font-bold" id="addModalLabel">Tambah Filter</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- MODAL BODY --}}
                <div class="modal-body p-4">
                    {{-- FILTER KATEGORI DAN KARAT --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h5 class="mb-2">Filter Kategori: </h5>
                            <div class="row">
                                @foreach ($categories as $category)
                                    <div class="col-3">
                                        <input type="checkbox" id="category_{{ $category->id }}" value="{{ $category->id }}"
                                            class="category-filter">
                                        <label for="category_{{ $category->id }}">{{ $category->category_code }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12">
                            <h5 class="mb-2">Filter Karat: </h5>
                            <div class="row">
                                @foreach ($karats as $karat)
                                    <div class="col-4">
                                        <input type="checkbox" id="karat_{{ $karat->id }}" value="{{ $karat->id }}"
                                            class="karat-filter">
                                        <label for="karat_{{ $karat->id }}">{{ $karat->name }}</label>
                                    </div>
                                @endforeach
                            </div>
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
        $(document).ready(function() {

            // uncheck semua checkbox saat halaman dimuat pertama kali
            $('.category-filter, .karat-filter').prop('checked', false);

            // ambil filter categories
            function getSelectedCategories() {
                const categories = [];

                // menyimpan value dari input checkbox yang di-checked ke dalam categories
                $('.category-filter:checked').each(function() {
                    categories.push($(this).val());
                });
                return categories;
            };

            // ambil filter karats
            function getSelectedKarats() {
                const karats = [];

                // menyimpan value dari input checkbox yang di-checked ke dalam karats
                $('.karat-filter:checked').each(function() {
                    karats.push($(this).val());
                });
                return karats;
            };

            let stockReportTable = $('#stockReportTable').DataTable({
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
                ajax: {
                    url: '{{ route('stock-report-data.index') }}',
                    data: function(d) {
                        d.categories = getSelectedCategories();
                        d.karats = getSelectedKarats();
                        // console.log(d); // debug data d
                    }
                },
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
            });

            stockReportTable.buttons().container().appendTo("#buttons");

            // auto submit ketika checkbox di change
            $('.category-filter, .karat-filter').on('change', function() {
                stockReportTable.ajax.reload();
            });
        });
    </script>
@endpush
