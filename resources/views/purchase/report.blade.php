@extends('layouts.app')
@section('title', 'Report Sale')
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

    #datatable tbody td:empty {
        border-top: none !important;
        border-bottom: none !important;
    }

    #datatable tbody tr td:first-child:empty {   /* kolom No yang kosong */
        border-left: none !important;
    }
</style>
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Report</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between pb-3 border-bottom">
                        <div>
                            <i class="bi bi-plus"></i> &nbsp; <span class="text-lg font-semibold"> Report Pembelian</span>
                        </div>
                        <div id="buttons"></div>
                    </div>
                    {{-- <button type="button" id="resetFilter" class="btn btn-sm btn-secondary">Reset</button> --}}
                    <div class="clearfix"></div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Invoice</th>
                                    <th>Jam</th>
                                    {{-- <th>Kode Barcode</th>
                                    <th>Kode Intern</th>
                                    <th>Kode Sales</th> --}}
                                    <th>Supplier</th>
                                    <th>Karat</th>
                                    {{-- <th>Kadar</th> --}}
                                    <th>Berat</th>
                                    <th>#</th>
                 <!-- <th style="width: 18%!important;" class="text-center">
                                        Action
                                    </th> -->
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
<script src="{{  asset('js/jquery.min.js') }}"></script>

<script type="text/javascript">
    jQuery.noConflict();

    function getotal(number){
            $('#total_' + number).val(0);
            let acc     = parseInt($('#acc_' + number).val());
            console.log(acc);
            let tag     = parseInt($('#tag_' + number).val());
            let emas    = parseInt($('#emas_' + number).val());
            let total   = acc + tag + emas;
            $('#total_' + number).val(total);
        }

        function gencode(number){
            console.log(number);
            let rand    = Math.floor(Math.random() * 1000);
            let group   = $('#group_' + number).find('option:selected').text();
            group       = group.substring(0, 1);
            let categoryCode = $('#product_category_' + number).find('option:selected').attr('code');

            let karat   = $('#karat_' + number).find('option:selected').text();
            karat       = karat.split('|')[0]?.trim();
            let date    = new Date();
            let formattedDate = ("0" + date.getDate()).slice(-2) + ("0" + (date.getMonth() + 1)).slice(-2) + date.getFullYear().toString().slice(-2);
            let code    = categoryCode+karat+formattedDate+rand;
            $("#code_"+number).val(code);
        }

        // (function($) {
        //     $(document).ready(function () {

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
    rowsGroup: [1, 2],
    "aaSorting": [[0, "desc"]],
    "columnDefs": [
        {
            "targets": 'no-sort',
            "orderable": false,
        }
    ],
    "sPaginationType": "simple_numbers",
    ajax: {
        url: '/purchases/data_report',
    },
    dom: 'Blfrtip',
    buttons: [
        {
            extend: 'excel',
            exportOptions: { columns: [0,1,2,3,4,5,6] }
        },
        {
            extend: 'pdf',
            exportOptions: { columns: [0,1,2,3,4,5,6] }
        },
        {
            extend: 'print',
            exportOptions: { columns: [0,1,2,3,4,5,6] }
        }
    ],
    columns: [
        {
            data: 'id',
            sortable: false,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {data: 'code',     name: 'code'},
        {data: 'invoice',  name: 'invoice'},
        {data: 'jam',      name: 'jam'},
        {data: 'supplier', name: 'supplier'},
        {data: 'karat',    name: 'karat'},
        {data: 'berat',    name: 'berat'},
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ],
    drawCallback: numberingByGroup
});

function numberingByGroup(settings) {
    const api = this.api();
    let idx = 1;
    let lastCode = null;
    let prevCode = null;
    let prevInvoice = null;

    api.rows({ page: 'current' }).every(function (rowIdx) {
        let data = this.data();
        let codeCell = api.cell(rowIdx, 1).node();     // kolom ke-1 = code
        let invoiceCell = api.cell(rowIdx, 2).node();  // kolom ke-2 = invoice

        if (data.code === prevCode) $(codeCell).html('');
        else prevCode = data.code;

        if (data.invoice === prevInvoice) $(invoiceCell).html('');
        else prevInvoice = data.invoice;
    });

    api.rows({ page: 'current' }).every(function (rowIdx) {
        const data = this.data();
        const noCell = api.cell(rowIdx, 0).node(); // kolom 'No'

        if (data.code !== lastCode) {
            $(noCell).html(idx++); // tampilkan nomor baru
            lastCode = data.code;
        } else {
            $(noCell).html('');    // baris detail: kosongkan
        }
    });
}



</script>
<script src="https://cdn.datatables.net/1.13.10/js/jquery.dataTables.min.js"></script>

<!-- ✅ 3. RowGroup (harus setelah core) -->
<script src="https://cdn.datatables.net/rowgroup/1.4.1/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script type="text/javascript">

jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah,#QrCode,#Show, #Edit', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }

         if($(this).attr('id') == 'QrCode')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Cetak QR Code');
        }

         if($(this).attr('id') == 'Show')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Detail');
        }

        $('#ModalContent').load($(this).attr('href'));
        // var myModalEl = document.getElementById('ModalGue');
        // var modal = new bootstrap.Modal(myModalEl);
        // modal.show();
        $('#ModalGue').modal('show');
    });


})(jQuery);
</script>

@endpush
