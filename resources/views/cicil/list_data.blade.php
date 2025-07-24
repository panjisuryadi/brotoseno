@extends('layouts.app')
@section('title', 'Cicil Data')
@section('third_party_stylesheets')
<style>
body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        page-break-before: always;
    }
.invoice {
    width: 100%;
    max-width: 900px;
    border: 1px solid #000;
    padding: 20px;
    background-color: #f9f9f9;
}
.header, .footer {
    text-align: center;
    margin-bottom: 10px;
}
.header img {
    width: 100px;
}
.invoice-details, .total {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
.invoice-details div, .total div {
    width: 45%;
}
.total {
    margin-top: 20px;
    font-size: 18px;
    font-weight: bold;
}
.invoice-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
.invoice-table th, .invoice-table td {
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
    <li class="breadcrumb-item active">{{$module_title}}</li>
</ol>
@endsection
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    <h2>No TRX</h2>
                </div>

                <div class="col-2">
                    <h2>Customer</h2>
                </div>

                <div class="col-2">
                    <h2>Total Trx</h2>
                </div>

                <div class="col-2">
                    <h2>Paid</h2>
                </div>

                <div class="col-2">
                    <h2>Sisa</h2>
                </div>

                <div class="col-2">
                    <h2>Installments</h2>
                </div>
            </div>
            <div class="row mt-1 font-weight-bold">
                <div class="col-2">
                    <h2>{{$cicil->sales_gold->nomor}}</h2>
                </div>

                <div class="col-2">
                    <h2>{{$cicil->customers->customer_name}}</h2>
                </div>

                <div class="col-2">
                    <h2>{{number_format($cicil->total_trx)}}</h2>
                </div>

                <div class="col-2">
                    <h2>{{number_format($cicil->paid)}}</h2>
                </div>

                <div class="col-2">
                    <h2>{{number_format($cicil->sisa)}}</h2>
                </div>

                <div class="col-2">
                    <h2>{{number_format($cicil->installments)}}</h2>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <a href="#" class="btn btn-success">+ Cicil</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-1">
                        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">
                                        NO
                                    </th>
                                    <th style="width: 10%!important;">
                                        Nominal
                                    </th>
                                    <th style="width: 10%!important;">
                                        Method
                                    </th>
                                    <th style="width: 10%!important;">
                                        Bank
                                    </th>
                                     <th style="width: 10%!important;" class="text-center">
                                        Rekening
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
        function detail_modal(id){
            document.getElementById('id').value = id;
        }

        function close_modal(id){
            document.getElementById('id_close').value = id;
        }
    </script>

    <script type="text/javascript">
        
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
            ajax: '{{ route("cicil.index_data") }}',
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
                    data: 'trx',
                    name: 'trx'
                },
                {
                    data: 'customer',
                    name: 'customer'
                },{
                    data: 'total_trx',
                    name: 'total_trx'
                },{
                    data: 'paid',
                    name: 'paid'
                },{
                    data: 'sisa',
                    name: 'sisa'
                },{
                    data: 'installments',
                    name: 'installments'
                },{
                    data: 'status',
                    name: 'status'
                },{
                    data: 'action',
                    name: 'action'
                },
                
            ]
        })
        .buttons()
        .container()
        .appendTo("#buttons");
jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah, #Edit', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush
