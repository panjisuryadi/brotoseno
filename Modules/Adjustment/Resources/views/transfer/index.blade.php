@extends('layouts.app')

@section('title', 'Stock Transfer')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> @lang('Stock Transfer')</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('stocktransfer.create') }}" class="btn btn-primary">
                            @lang('Add Stock Transfer')  <i class="bi bi-plus"></i>
                        </a>
                        <div class="pt-2 pb-2">
                            <hr>
                        </div>
                            

                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dataTable no-footer">
                                <thead>
                                    <th>Tanggal</th>
                                    <th>Reference</th>
                                    <th>Summary</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
<script type="text/javascript" src="{{ asset('js/export/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/buttons.html5.min.js') }}"></script>
<script>
    $(function(){
        datatable()
    })
    function datatable(){
        $('#datatable').DataTable({
                destroy: true,
            }).destroy();

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                language: {
                    sEmptyTable:   "Tidak ada data yang tersedia pada tabel ini",
                    sProcessing:   "Sedang memproses...",
                    sLengthMenu:   "Tampilkan _MENU_ data",
                    sZeroRecords:  "Tidak ditemukan data yang sesuai",
                    sInfoFiltered: "(disaring dari _MAX_ data keseluruhan)",
                    sInfoPostFix:  "",
                    sSearch:       "Cari:",
                    sUrl:          "",
                },
                dom: "<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>>'tr'<'row'<'col-md-5'i><'col-md-7 mt-2'p>>",
                buttons: [
                    {
                        text: '<i class="bi bi-file-earmark-excel-fill"></i> Excel',
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF',
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="bi bi-printer-fill"></i> Print',
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="bi bi-x-circle"></i> Reset',
                        action: function () {
                            $('#your-datatable-id').DataTable().search('').columns().search('').draw();
                        }
                    },
                    {
                        text: '<i class="bi bi-arrow-repeat"></i> Reload',
                        action: function () {
                            $('#datatable').DataTable().ajax.reload(null, false);
                        }
                    }
                ],
                ajax: {
                    url:'stocktransfer/getdata',
                    type:"GET",
                },
                order : [0,'desc'],
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'reference', name: 'reference' },
                    { data: 'transferdetail', name: 'transferdetail' },
                    { data: 'action', name: 'action' },
                ], 
                columnDefs: [
                    { 
                        width: "10", 
                        targets: [3]
                    },
                ],
            });
    }
</script>
@endpush



@push('page_css')
 <style type="text/css">

.aksi{
   width: 12% !important;
}
.tgl{
   width: 10% !important;
}

   </style>
@endpush
