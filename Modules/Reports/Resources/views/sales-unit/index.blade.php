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
<!-- filter -->
                            {{-- FILTER LAPORAN --}}
                            <div class="container-fluid">
                                <div class="row g-3 align-items-end my-3">

                                    {{-- Bulan --}}
                                    {{-- <div class="col-md-3 col-sm-6">
                                        <label for="bulan" class="small">Bulan</label>
                                        <select id="bulan" class="form-control form-control-sm">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div> --}}

                                    {{-- Tahun --}}
                                    {{-- <div class="col-md-3 col-sm-6">
                                        <label for="tahun" class="small">Tahun</label>
                                        <select id="tahun" class="form-control form-control-sm">
                                            @for ($i = now()->year; $i >= 2020; $i--)
                                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div> --}}

                                    {{-- Karat --}}

                                    <form id="filterForm" class="mb-3">
                                        <div class="form-row align-items-end">
                                            {{-- Start Date --}}
                                            <div class="col-md-3 col-sm-6 mb-2">
                                                <label for="startDate" class="small">Dari Tanggal</label>
                                                <input type="date" name="startDate" id="startDate"
                                                    class="form-control form-control-sm"
                                                    value="{{ request('startDate') }}">
                                            </div>

                                            {{-- End Date --}}
                                            <div class="col-md-3 col-sm-6 mb-2">
                                                <label for="endDate" class="small">Sampai Tanggal</label>
                                                <input type="date" name="endDate" id="endDate"
                                                    class="form-control form-control-sm"
                                                    value="{{ request('endDate') }}">
                                            </div>


                                            {{-- Tombol Filter --}}
                                            <div class="col-md-3 col-sm-6 mb-2">
                                                <label class="invisible d-block">Tombol</label>
                                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                                @php
                                                $startDate = $_GET['startDate'] ?? date('Y-m-d', strtotime('-30 days'));
                                                $endDate    = $_GET['endDate'] ?? date('Y-m-d');
                                                $karats     = $_GET['karat'] ?? 0;
                                                @endphp
                                                <a href="/sales-unit/report/excel?endDate={{$endDate}}&startDate={{$startDate}}" class="btn btn-sm btn-success">Excel</a>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Tombol Filter --}}
                                    {{-- <div class="col-md-2 col-sm-6">
                                        <button id="filterBtn" class="btn btn-primary btn-sm w-100">
                                            Filter
                                        </button>
                                    </div> --}}
                                </div>
                            </div>
                            <!-- endfilter -->

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
                ajax: {
                    url: '{{ route('sales-unit-report-data.index') }}',
                    data: function(d) {
                        // d.bulan = $('#bulan').val();
                        // d.tahun = $('#tahun').val();
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                    },
                    error: function (xhr, error, thrown) {
                        alert('Gagal memuat data dari server. Cek console untuk detail.');
                        console.error(xhr.responseText);
                    }
                },
                // ajax: '{{ route('sales-unit-report-data.index') }}',
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
