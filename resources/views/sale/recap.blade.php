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
</style>
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Report Recap</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">

    @can('show_total_stats')
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                            <i class="bi bi-cash font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-primary">{{ format_currency($totalGoldSales) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                                @lang('Sales')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                            <i class="bi bi-speedometer2 font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-warning">{{ $totalGoldWeight }} Gram</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                          @lang('Sales Weight')
                        </div>
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
                            <div class="text-value text-success">{{ $totalGoldQuantity }} Pcs</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                            @lang('Sales Quantity')
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                            <i class="bi bi-people font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-info">{{ $totalCustomer }} Orang</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                             @lang('Total Customer')
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between pb-3 border-bottom">
                        <div>
                            <i class="bi bi-plus"></i> &nbsp; <span class="text-lg font-semibold"> List Sales</span>
                        </div>
                        <div id="buttons"></div>
                    </div>

                    {{-- filter bulanan --}}
                    <div class="row align-items-end mt-3">
                        <div class="col-md-3 col-sm-6 mb-2">
                            <label for="bulan" class="small">Bulan</label>
                            <select id="bulan" class="form-control form-control-sm">
                                <option value="">Semua</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <label for="tahun" class="small">Tahun</label>
                            <select id="tahun" class="form-control form-control-sm">
                                <option value="">Semua</option>
                                @for ($i = now()->year; $i >= 2020; $i--)
                                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-2">
                            <button id="filterBtn" class="btn btn-sm btn-primary w-100 mt-2">Filter</button>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">NO</th>
                                    <th style="width: 15%!important;" class="text-center">Date</th>
                                    <th style="width: 15%!important;" class="text-center">Berat</th>
                                    <th style="width: 10%!important;" class="text-center">IDR</th>
                                    {{-- <th style="width: 15%!important;" class="text-center">#</th> --}}

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

    let table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        lengthChange: true,
        searching: true,
        "oLanguage": {
            "sSearch": "<i class='bi bi-search'></i> Cari : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data per halaman",
            "sInfo": "Menampilkan _START_ - _END_ dari <b>_TOTAL_</b> data",
            "sInfoFiltered": "(disaring dari _MAX_ total data)",
            "sZeroRecords": "Data tidak ditemukan",
            "sEmptyTable": "Tidak ada data tersedia",
            "sLoadingRecords": "Harap Tunggu...",
            "oPaginate": {
                "sPrevious": "Sebelumnya",
                "sNext": "Berikutnya"
            }
        },
        "aaSorting": [[ 1, "desc" ]],
        "sPaginationType": "simple_numbers",

        // ajax: '/sale/recap/data', // tanpa filter tanggal
        ajax: {
            url: '/sale/recap/data',
            data: function(d) {
                d.bulan = $('#bulan').val();
                d.tahun = $('#tahun').val();
            },
            error: function (xhr, error, thrown) {
                alert('Gagal memuat data dari server. Cek console untuk detail.');
                console.error(xhr.responseText);
            }
        },


        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'excel',
                exportOptions: { columns: [0, 1, 2, 3] }
            },
            {
                extend: 'pdf',
                title: `${$('#bulan option:selected').text()} ${$('#tahun option:selected').text()}`,
                exportOptions: { columns: [0, 1, 2, 3] },
                customize: function(doc) {
                        // Rata tengah semua isi tabel
                        doc.styles.tableHeader.alignment = 'center';
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyOdd.alignment = 'center';

                        // Atur padding dan garis supaya lebih rapi
                        doc.content[1].layout = {
                            hLineWidth: function(i) { return 0.5; },
                            vLineWidth: function(i) { return 0.5; },
                            hLineColor: function(i) { return '#aaa'; },
                            vLineColor: function(i) { return '#aaa'; },
                            paddingLeft: function(i) { return 5; },
                            paddingRight: function(i) { return 5; }
                        };

                        // Atur ukuran kolom secara proporsional (optional)
                        doc.content[1].table.widths =['10%', '30%', '30%', '30%'];
                    }
            },
            {
                extend: 'print',
                exportOptions: { columns: [0, 1, 2, 3] }
            }
        ],
        columns: [
            {
                data: null,
                sortable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'tanggal',
                name: 'tanggal',
                className: 'text-center'
            },
            {
                data: 'berat_emas',
                name: 'berat_emas',
                className: 'text-center'
            },
            {
                data: 'total',
                name: 'total',
                className: 'text-center'
            },
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false,
            //     className: 'text-center'
            // }
        ]
    });

//     $('#filterBtn').on('click', function () {
//     table.ajax.reload();
// });

$('#filterBtn').on('click', function () {
    const bulan = $('#bulan').val();
    const tahun = $('#tahun').val();
    const query = `?bulan=${bulan}&tahun=${tahun}`;
    window.location.href = location.pathname + query;
});

</script>
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
