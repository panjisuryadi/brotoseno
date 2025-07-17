@extends('layouts.app')
@section('title', 'Report Sales')
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
        <li class="breadcrumb-item"><a href="{{ route('sales-customers-report.index') }}">{{ __("Sales Per Customers") }}</a></li>
        <li class="breadcrumb-item active">Detail {{ __("Sales Per Customers") }}</li>
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
                                <i class="bi bi-plus"></i> &nbsp; <span class="text-lg font-semibold"> Detail Pembelian Pelanggan: {{ $customer_name }}</span>
                            </div>
                            <div id="buttons"></div>
                        </div>

                        {{-- FILTER TANGGAL --}}
                        <form id="filterForm" class="form-inline mb-2" style="float: right;">
                            <input type="date" name="startDate" id="startDate" class="form-control form-control-sm mx-1"
                                placeholder="Dari" value="{{ request('startDate') }}">

                            <input type="date" name="endDate" id="endDate" class="form-control form-control-sm mx-1"
                                placeholder="Sampai" value="{{ request('endDate') }}">

                            <button type="submit" class="btn btn-sm mx-1 btn-primary">Filter</button>
                        </form>
                        {{-- <button type="button" id="resetFilter" class="btn btn-sm btn-secondary">Reset</button> --}}

                        {{-- TABLE REPORT SALE --}}
                        <div class="clearfix"></div>
                        <div class="table-responsive mt-1">
                            <table id="datatable" style="width: 100%"
                                class="table table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 5%!important;">NO</th>
                                        <th style="width: 10%!important;">Nomor Trx</th>
                                        <th style="width: 30%!important;">Tanggal | Jam</th>
                                        <th style="width: 10%!important;">Sales</th>
                                        <th style="width: 10%!important;">Customer</th>
                                        <th style="width: 10%!important;">Kategori</th>
                                        <th style="width: 10%!important;">Barang</th>
                                        <th style="width: 10%!important;">Berat (gram)</th>
                                        <th style="width: 10%!important;">Karat</th>
                                        <th style="width: 10%!important;">H.jual</th>
                                        <th style="width: 10%!important;">Ongkos</th>
                                        <th style="width: 10%!important;">Total</th>
                                        <th style="width: 10%!important;">Cash</th>
                                        <th style="width: 10%!important;">Transfer</th>
                                        <th style="width: 10%!important;">Edc</th>
                                        <th style="width: 10%!important;">Qr</th>
                                        <th style="width: 10%!important;">Rata 2</th>
                                        <th style="width: 10%!important;">Keterangan</th>
                                        <th style="width: 10%!important;">#</th>
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

        function getotal(number) {
            $('#total_' + number).val(0);
            let acc = parseInt($('#acc_' + number).val());
            console.log(acc);
            let tag = parseInt($('#tag_' + number).val());
            let emas = parseInt($('#emas_' + number).val());
            let total = acc + tag + emas;
            $('#total_' + number).val(total);
        }

        function gencode(number) {
            console.log(number);
            let rand = Math.floor(Math.random() * 1000);
            let group = $('#group_' + number).find('option:selected').text();
            group = group.substring(0, 1);
            let categoryCode = $('#product_category_' + number).find('option:selected').attr('code');

            let karat = $('#karat_' + number).find('option:selected').text();
            karat = karat.split('|')[0]?.trim();
            let date = new Date();
            let formattedDate = ("0" + date.getDate()).slice(-2) + ("0" + (date.getMonth() + 1)).slice(-2) + date
                .getFullYear().toString().slice(-2);
            let code = categoryCode + karat + formattedDate + rand;
            $("#code_" + number).val(code);
        }

        let customer_id = "{{ $customer_id }}";
        console.log(customer_id);

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
                ajax: {
                    url: '/sales-customers/report/data/' + customer_id,
                    data: function(d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                        console.log(d);
                    }
                },
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
                        data: 'nomor_transaksi',
                        name: 'nomor_transaksi'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'sales',
                        name: 'sales'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'category_code',
                        name: 'category_code'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'berat_emas',
                        name: 'berat_emas'
                    },
                    {
                        data: 'karat',
                        name: 'karat'
                    },
                    {
                        data: 'h_jual',
                        name: 'h_jual'
                    },
                    {
                        data: 'ongkos',
                        name: 'ongkos'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'cash',
                        name: 'cash'
                    },
                    {
                        data: 'transfer',
                        name: 'transfer'
                    },
                    {
                        data: 'edc',
                        name: 'edc'
                    },
                    {
                        data: 'qr',
                        name: 'qr'
                    },
                    {
                        data: 'rata_rata',
                        name: 'rata_rata'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    </script>
@endpush
