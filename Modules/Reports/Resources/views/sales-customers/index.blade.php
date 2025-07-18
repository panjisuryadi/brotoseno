@extends('layouts.app')
@section('title', 'Report Sales Customers')
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

        .dropzone {
            height: 280px !important;
            min-height: 190px !important;
            border: 2px dashed #FF9800 !important;
            border-radius: 8px;
            background: #ff98003d !important;
        }

        .dropzone i.bi.bi-cloud-arrow-up {
            font-size: 5rem;
            color: #bd4019 !important;
        }
    </style>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ __("Sales Per Customers") }}</li>
    </ol>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- JUDUL DAN BUTTON EXCEL DLL --}}
                        <div class="flex justify-between pb-3 border-bottom">
                            <div>
                                <i class="bi bi-plus"></i> &nbsp; <span class="text-lg font-semibold"> List {{ __("Sales Per Customers") }}</span>
                            </div>
                            <div id="buttons"></div>
                        </div>

                        {{-- TABLE REPORT SALE --}}
                        <div class="clearfix"></div>
                        <div class="table-responsive mt-1">
                            <table id="datatable" style="width: 100%"
                                class="table table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 5%!important;">NO</th>
                                        <th style="width: 10%!important;">Nama Customer</th>
                                        <th style="width: 10%!important;">Nomor Hp Customer</th>
                                        <th style="width: 10%!important;">Total Pembelian</th>
                                        <th style="width: 10%!important;">Total Berat</th>
                                        <th style="width: 5%!important;">Total Kuantitas</th>
                                        <th style="width: 5%!important;">Aksi</th>
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
@section('third_party_scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
@push('page_scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script type="text/javascript">
        jQuery.noConflict();

        let table = $('#datatable').DataTable({
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
                ajax: '/sales-customers/report/data',
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 8;
                        },
                        exportOptions: {
                            columns: ':lt(18)'
                        },
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
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
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone'
                    },
                    {
                        data: 'total_pembelian',
                        name: 'total_pembelian'
                    },
                    {
                        data: 'total_berat',
                        name: 'total_berat'
                    },
                    {
                        data: 'total_kuantitas',
                        name: 'total_kuantitas'
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
@endpush
