@extends('layouts.app')
@section('title', 'Webcam')
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
        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
            <thead>
                <tr>
                    <th style="width: 5%!important;">No</th>
                    <th style="width: 20%!important;">Username/Email</th>
                    <th style="width: 20%!important;">Tenant Name</th>
                    <th style="width: 15%!important;">Subscription</th>
                    <th style="width: 10%!important;">Input Product</th>
                    <th style="width: 10%!important;">Sale</th>
                    <th style="width: 15%!important;">Last Seen</th>
                    <th style="width: 5%!important;" class="text-center">#</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

</div>

@endsection
<x-library.datatable />
@push('page_scripts')
    

<script>
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
    ajax: '/tenant/index_data',
    dom: 'lfrtip',
    // dom: 'Blfrtip',
    columns: [{
        "data": 'id',
        "sortable": false,
        render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    },
    {
        data: 'email',
        name: 'email'
    }, {
        data: 'name',
        name: 'name'
    }, {
        data: 'sub',
        name: 'sub'
    },
    {
        data: 'karat',
        name: 'karat'
    }, 
    {
        data: 'rekomendasi',
        name: 'rekomendasi'
    }, 

    // {
    //     data: 'rounded',
    //     name: 'rounded'
    // }, 
    // {
    //     data: 'created_at',
    //     name: 'created_at'
    // },
    {
        data: null,
        className: 'text-center',
        render: function(data, type, row, meta) {
            return `<button class="btn btn-sm btn-success btn-add-to-preview" data-row='${JSON.stringify(row)}'>Add</button>`;
        }
    },

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
