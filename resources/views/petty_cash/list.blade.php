@extends('layouts.app')
@section('title', 'Petty Cash')
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
<div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                        <i class="bi bi-bar-chart font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">Rp. {{number_format($pettycash->current)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                        Petty Cash                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                        <i class="bi bi-arrow-return-left font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-warning">Rp. {{number_format($pettycash->in)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                        Penjualan                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                        <i class="bi bi-arrow-return-right font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-success">Rp. {{number_format($buyback)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                        Buyback                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0">
                <div class="card-body p-0 d-flex align-items-center shadow-sm">
                    <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                        <i class="bi bi-trophy font-2xl"></i>
                    </div>
                    <div>
                        <div class="text-value text-info">Rp. {{number_format($luar)}}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">
                            Barang Luar                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($status == 'B')
                    <div class="flex justify-between py-1 border-bottom">
                        <div class="btn-group">
                            <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#createModal">
                                Create Petty Cash <i class="bi bi-plus"></i>
                            </a>
                        </div>
                    </div>
                    @endif
                    <div class="table-responsive mt-1">
                        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">
                                        NO
                                    </th>
                                    <th style="width: 10%!important;">
                                        Tanggal
                                    </th>
                                    <th style="width: 10%!important;">
                                        Modal
                                    </th>
                                      
                                     <th style="width: 10%!important;" class="text-center">
                                        Cash In
                                    </th>  
                                    <th style="width: 10%!important;" class="text-center">
                                        Cash Out
                                    </th> 
                                    <th style="width: 10%!important;" class="text-center">
                                        Current
                                    </th>
                                    <th style="width: 10%!important;" class="text-center">
                                        Sisa
                                    </th>
                                    <th style="width: 18%!important;" class="text-center">
                                        Keterangan
                                    </th> 
                                    <th style="width: 17%!important;" class="text-center">
                                        #
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


<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Petty Cash</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/pettycash/insert" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Modal</label>
                        <input type="number" name="modal" class="form-control" required>
                    </div>
                    <br>
                    <button class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Petty Cash</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/pettycash/update" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Modal</label>
                        <input type="hidden" name="id" id="id" required>
                        <input type="number" name="modal" class="form-control" required>
                    </div>
                    <br>
                    <button class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Petty Cash</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/pettycash/close" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Sisa</label>
                        <input type="hidden" name="id" id="id_close" required>
                        <input type="number" name="sisa" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" id="" class="form-control" required></textarea>
                    </div>
                    <br>
                    <button class="btn btn-sm btn-success" onclick="return confirm('Close Petty Cash ?');">Submit</button>
                </form>
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
            ajax: '{{ route("pettycash.index_data") }}',
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
                    data: 'modal',
                    name: 'modal'
                },
                {
                    data: 'current',
                    name: 'current'
                },{
                    data: 'in',
                    name: 'in'
                },{
                    data: 'out',
                    name: 'out'
                },{
                    data: 'final',
                    name: 'final'
                },{
                    data: 'keterangan',
                    name: 'keterangan'
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
