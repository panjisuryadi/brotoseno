@extends('layouts.app')
@section('title', 'Global')
@section('third_party_stylesheets')
    <style>
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-table td {
            background-color: #fff;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $module_title }}</li>
    </ol>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- FILTER TANGGAL --}}
                        <form id="filterForm" class="form-inline mb-2" style="float: right;">
                            <input type="date" name="startDate" id="startDate" class="form-control form-control-sm mx-1"
                                placeholder="Dari" value="{{ request('startDate') }}">

                            <input type="date" name="endDate" id="endDate" class="form-control form-control-sm mx-1"
                                placeholder="Sampai" value="{{ request('endDate') }}">

                            <button type="submit" class="btn btn-sm mx-1 btn-primary">Filter</button>
                            @php
                            $startDate = $_GET['startDate'] ?? date('Y-m-d', strtotime('-30 days'));
                            $endDate    = $_GET['endDate'] ?? date('Y-m-d');
                            @endphp
                            <a href="/sale/excel_product_in?endDate={{$endDate}}&startDate={{$startDate}}" class="btn btn-sm btn-success">Excel</a>
                        </form>

                        <div class="table-responsive mt-1">
                            <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 5%!important;" class="text-center">
                                            NO
                                        </th>
                                        <th style="width: 20%!important;" class="text-center">
                                            Tanggal
                                        </th>
                                        <th style="width: 13%!important;" class="text-center">
                                            Karat
                                        </th>
                                        <th style="width: 20%!important;" class="text-center">
                                            Berat
                                        </th>
                                        <th style="width: 10%!important;" class="text-center">
                                            Total
                                        </th>
                                        <th style="width: 10%!important;" class="text-center">
                                            Est Nominal
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
                    url: '/sale/index_product_in',
                    data: function(d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                        console.log(d);
                    }
                },
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

                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'karat',
                        name: 'karat'
                    },
                    {
                        data: 'berat',
                        name: 'berat'
                    }, {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal'
                    },
                ]
            })
            .buttons()
            .container()
            .appendTo("#buttons");

        $('#startDate, #endDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
        console.log('script loaded');

        $(document).ready(function() {
            $('#startDate').val('');
            $('#endDate').val('');
            table.ajax.reload();
        });

        // Event onsubmit
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            const start = $('#startDate').val();
            const end = $('#endDate').val();

            if (start && end && start > end) {
                alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
                return;
            }

            table.ajax.reload();
        });
    </script>

    <script type="text/javascript">
        jQuery.noConflict();
    </script>
    <script src="./js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        
    </script>
@endpush
