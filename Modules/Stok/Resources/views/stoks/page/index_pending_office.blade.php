@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb m-0 border-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $module_title }} {{ $module_action }}</li>
    </ol>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom flex justify-between py-1">
                            <div>
                                <p class="text-lg font-semibold uppercase text-gray-600">
                                    Stok
                                    <span class="uppercase text-yellow-500">{{ $module_action }}</span>
                                </p>
                            </div>
                            <div id="exportButton">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 py-3">
                            @if (count($datakarat))
                                <div class="card">
                                    <div class="card-body font-semibold">
                                        <p>Info Stok</p>
                                        <p>Karat : <span id="karat"></span></p>
                                        <p>Sisa Stok : <span id="sisa-stok"></span></p>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="karat_filter" class="mb-0 font-semibold">Pilih Karat</label>
                                    <select name="karat_filter" id="karat_filter" class="form-control">
                                        <option value="">Silahkan Pilih Karat</option>
                                        @foreach ($datakarat as $karat)
                                            <option value="{{ $karat->id }}">{{ $karat->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>
                        <div class="table-responsive mt-1">

                            <table id="datatable" style="width: 100%"
                                class="table-bordered table-hover table-responsive-sm table">
                                <thead>
                                    <tr>
                                        <th style="width: 6%!important;">No</th>
                                        <th class="text-left">{{ Label_Case('Karat') }}</th>
                                        <th class="text-left">{{ Label_Case('Product') }}</th>
                                        <th class="text-left">{{ Label_Case('Total Berat') }}</th>
                                        <th class="text-left">{{ Label_Case('Pcs') }}</th>
                                        <th class="text-left">{{ Label_Case('aksi') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('product::products.modal.process')
    </div>
@endsection
@php
    $status_id_ready_office = $add_data['status_id_ready_office'] ?? 0;
@endphp
<x-library.datatable />
@push('page_scripts')
    <script type="text/javascript">
        var status_id_ready_office = "{{ $status_id_ready_office }}";
        var _datas = [];
        $(function() {
            datatable()
            getStockInfo()
        })

        function datatable() {
            $('#datatable').DataTable({
                destroy: true,
            }).destroy();
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
                    ajax: '{{ route("$module_name.index_data_pending_office") }}?karat=' + $('#karat_filter').val(),
                    dom: 'Blfrtip',
                    buttons: [

                        'excel',
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
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'product',
                            name: 'product'
                        },
                        {
                            data: 'weight',
                            name: 'weight'
                        },
                        {
                            data: 'kuantitas',
                            name: 'kuantitas'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ]
                })
                .buttons()
                .container()
                .appendTo("#exportButton");
        }
        $('#karat_filter').change(function() {
            datatable()
            getStockInfo()
        })

        function getStockInfo() {
            $.ajax({
                type: "get",
                url: '{{ route("$module_name.get_stock_pending_office") }}?karat=' + $('#karat_filter').val(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(data) {
                    $('#karat').text(data.karat)
                    $('#sisa-stok').text(data.sisa_stok + ' gr')
                }
            })
        }


        function process(data) {
            _datas = data;
            $('#product-process-modal').modal('show')
            $('#product-process-modal #data_name').val(data.name)
            $('#product-process-modal #data_category').val(data.category_name)
            $('#product-process-modal #data_id').val(data.id)
        }

        $('#form-product-process').submit(function() {
            $.ajax({
                type: "POST",
                url: '{{ route('products.update_status') }}',
                data: $('#form-product-process').serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(data) {
                    if (data.status == 'success') {
                        toastr.success(data.message)
                        setTimeout(function() {
                            window.location.reload()
                            $('#product-process-modal').modal('hide')
                        }, 1000);
                    } else {
                        toastr.error('Kesalahan input!')
                        printErrorMsg(data.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) { // if error occured
                    data = JSON.parse(jqXHR.responseText);
                    if (data.message == 'The given data was invalid.') {
                        err = data.errors;
                        $.each(err, function(key, val) {
                            $("." + key + "_field .fv-plugins-message-container").text(val);
                            $("." + key + "_field .fv-plugins-message-container").show();
                        });

                        toastr.error(data.message);
                    } else {
                        toastr.error("Error occured. " + jqXHR.status + " " + textStatus + " " +
                            " please try again");
                    }
                }
            })
            return false;
        })
    </script>
@endpush
