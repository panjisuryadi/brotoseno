@extends('layouts.app')

@section('title', 'Expenses')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Expenses</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        @php
        $total_masuk = $data->sum('amount');
        $total_keluar = $data->sum('amount_out');
        $total = $total_masuk - $total_keluar;
    @endphp
        <div class=" px-0 py-2 grid grid-cols-3 gap-4 m-2 text-center no-underline">
            <div class="no-underline cursor-pointer px-0 py-2 w-full">
                <a class="w-full no-underline hover:no-underline" id="openModalKategori"
                    href="#" >
                    <div class="justify-center items-center border-2 border-gray-400 bg-white  px-2 py-3 rounded-lg transform transition duration-500 hover:scale-110">
                        <div class="justify-center text-center items-center">

                        </div>
                        <div class="font-semibold text-gray-600 no-underline hover:text-red-600 leading-tight">
                        Masuk : {{ format_uang($total_masuk) }}
                        </div>
                    </div>
                </a>
            </div>
            <div class="no-underline cursor-pointer px-0 py-2 w-full">
                <a class="w-full no-underline hover:no-underline" id="openModalKategori"
                    href="#" >
                    <div class="justify-center items-center border-2 border-gray-400 bg-white  px-2 py-3 rounded-lg transform transition duration-500 hover:scale-110">
                        <div class="justify-center text-center items-center">

                        </div>
                        <div class="font-semibold text-gray-600 no-underline hover:text-red-600 leading-tight">
                        Keluar : {{ format_uang($total_keluar) }}
                        </div>
                    </div>
                </a>
            </div>
            <div class="no-underline cursor-pointer px-0 py-2 w-full">
                <a class="w-full no-underline hover:no-underline" id="openModalKategori"
                    href="#" >
                    <div class="justify-center items-center border-2 border-gray-400 bg-white  px-2 py-3 rounded-lg transform transition duration-500 hover:scale-110">
                        <div class="justify-center text-center items-center">

                        </div>
                        <div class="font-semibold text-gray-600 no-underline hover:text-red-600 leading-tight">
                        Sisa : {{ format_uang($total) }}
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="startDate">Start Date</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="endDate">End Date</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex justify-between py-1 border-bottom">
                            <div>
                               <a href="{{ route('expenses.create') }}"
                                    id="Tambah"
                                    data-toggle="tooltip"
                                     class="btn btn-primary px-3">
                                     <i class="bi bi-plus"></i>@lang('Add')&nbsp;{{ $module_title }}
                                    </a>

                            </div>
                            <div id="buttons">
                            </div>
                        </div>
                        <div class="table-responsive mt-1">
                            <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 6%!important;">No</th>
                                       <th style="width: 15%!important;" class="text-center">{{ __('Date') }}</th>
                                        <th class="text-lef">{{ __('Reference') }}</th>
                                        <th class="text-lef">{{ __('Category') }}</th>
                                        <th class="text-lef">Masuk</th>
                                        <th class="text-lef">Keluar</th>
                                        <th class="text-lef">Detail</th>
                                        <th style="width: 10%!important;" class="text-center">
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
        let startDate = '';
        let endDate = '';

        $('#startDate, #endDate').on('change', function() {
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            // console.log(endDate);
            $('#datatable').DataTable().ajax.reload();
        });

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
            ajax: {
                    url: '{{ route("$module_name.index_data") }}',
                    data: function (d) {
                        d.startDate = startDate;
                        d.endDate = endDate;
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

                {data: 'date', name: 'date'},
                {data: 'reference', name: 'reference'},
                {data: 'kategori', name: 'kategori'},
                {data: 'masuk', name: 'masuk'},
                {data: 'keluar', name: 'keluar'},
                {data: 'detail', name: 'detail'},

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

    // $('#filter-form').on('submit', function(e) {
    //     e.preventDefault();
    //     var start = $('#start_date').val();
    //     table.draw();
    // });

    </script>
@endpush
