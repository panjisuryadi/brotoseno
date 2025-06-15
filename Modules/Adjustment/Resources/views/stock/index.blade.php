@extends('layouts.app')

@section('title', 'Stock')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> @lang('Stock')</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-lg" id="totalstok">{{$stock}}</div>
                        <div>Total Stok</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-lg" id="totalcategory">{{$category}}</div>
                        <div>Total Kategori</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-lg" id="totalaset">{{number_format($aset)}}</div>
                        <div>Nilai Aset</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-lg" id="totalproduct">{{$product}}</div>
                        <div>Total Produk</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="pb-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="" id="category" class="form-control">
                                            <option value="" selected>Semua Kategori</option>
                                            @foreach($categories as $categories)
                                            <option value="{{$categories->id}}">{{$categories->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="" id="location" class="form-control">
                                        <option value="" selected>Semua Lokasi</option>
                                        @foreach($locations as $p)
                                        <option value="{{ $p->id }}" disabled>{{ $p->name }}</option>
                                            @if(!empty($p->childs))
                                                @foreach($p->childs as $loc1)
                                                <option value="{{ $loc1->id }}">> {{ $loc1->name }}</option>
                                                    @if(!empty($loc1->childs))
                                                        @foreach($loc1->childs as $loc2)
                                                        <option value="{{ $loc2->id }}"> &nbsp;- {{ $loc2->name }}</option>
                                                            @if(!empty($loc2->childs))
                                                                @if(!empty($loc2->childs))
                                                                    @foreach($loc2->childs as $loc3)
                                                                    <option value="{{ $loc3->id }}">&nbsp; -> {{ $loc3->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive pt-2">
                            <table id="datatable" class="table table-bordered dataTable no-footer">
                                <thead>
                                    <th>Nama Product</th>
                                    <th>Kategori</th>
                                    <th>Stock</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('adjustment::partials.modal')
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
                serverSide: false,
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
                    url:'stocks/getdata?location_id='+$('#location').val()+'&category_id='+$('#category').val(),
                    type:"GET",
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category' },
                    { data: 'stock', name: 'stock' },
                    { data: 'location', name: 'location' },
                    { data: 'action', name: 'action' },
                ], 
                columnDefs: [
                    { 
                        width: "10", 
                        targets: [4]
                    },
                ],
            });
    }

$('#location').change(function(){
    datatable()
    summary()
})
$('#category').change(function(){
    datatable()
    summary()
})

function summary(){
    $.ajax({
            type: "GET",
            url: "{{ route('stock.getsummary') }}?location_id="+$('#location').val()+'&category_id='+$('#category').val(),
            dataType:'json',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $('#totalstok').html(data.stock)
                $('#totalproduct').html(data.product)
                $('#totalaset').html(data.aset)
                $('#totalcategory').html(data.category)
            }
        })
}

function showone(id){
    $.ajax({
            type: "GET",
            url: "stocks/getone/"+id,
            dataType:'json',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $('#product_name').html(data.name)
                $('#type_name').html(data.type)
                $('#stock_name').html(data.stock)
                $('#location_name').html(data.location)
                $('#exampleModal').modal('show');
            }
        })
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
