@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}} {{ $module_action }}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                     <div>
                       <p class="uppercase text-lg text-gray-600 font-semibold">
                      Stok
                      <span class="text-yellow-500 uppercase">{{$module_action}}</span>
                  </p>
                        </div>
                        <div id="exportReadyOffice">
                        </div>
                    </div>
                    <div class="flex justify-between">
                            @if (count($datakarat))
                            <div class="card">
                                <div class="card-body font-semibold">
                                    <p>Info Stok</p>
                                    <p>Karat : <span id="karat"></span></p>
                                    <p>Sisa Stok : <span id="sisa-stok"></span></p>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="karat_filter" class="font-bold">Pilih Karat</label>
                                <select name="karat_filter" id="karat_filter" class="form-control">
                                    @foreach ($datakarat as $karat )
                                    <option value="{{$karat->id}}">{{ $karat->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                    </div>
                    <div class="table-responsive mt-1">

                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                <th style="width: 6%!important;">No</th>
                                <th class="text-left">{{ Label_Case('Image') }}</th>
                                <th class="text-left">{{ Label_Case('Product') }}</th>
                                <th class="text-left">{{ Label_Case('Karat') }}</th>
                                <th class="text-left">{{ Label_Case('Berat') }}</th>
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

<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
        $(function(){
            datatable()
            getStockInfo()
        })
        function datatable(){
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
                ajax: '{{ route("$module_name.index_data_ready_office") }}?karat='+$('#karat_filter').val(),
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

                    {data: 'image', name: 'image'},
                    {data: 'product', name: 'product'},
                    {data: 'karat', name: 'karat'},
                    {data: 'weight', name: 'weight'},
                    {data: 'action', name: 'action'}
                ]
            })
            .buttons()
            .container()
            .appendTo("#exportReadyOffice");
        }
        $('#karat_filter').change(function(){
            datatable()
            getStockInfo()
        })

        function getStockInfo(){
            $.ajax({
                type: "get",
                url: '{{ route("$module_name.get_stock_ready_office") }}?karat='+$('#karat_filter').val(),
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept' : 'application/json'
                },
                success: function(data){
                    $('#karat').text(data.karat)
                    $('#sisa-stok').text(data.sisa_stok + ' gr')
                }
            })
        }


        function process(data){
            $('#product-process-modal').modal('show')
            $('#product-process-modal #data_name').val(data.name)
            $('#product-process-modal #data_category').val(data.category_name)
            $('#product-process-modal #data_id').val(data.id)
        }

        $('#form-product-process').submit(function(){
            $.ajax({
                type: "POST",
                url: '{{route("products.update_status")}}',
                data: $('#form-product-process').serialize(),
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept' : 'application/json'
                },
                success: function(data){
                    if(data.status == 'success'){
                        toastr.success(data.message)
                        setTimeout(function(){
                           window.location.reload()
                            $('#product-process-modal').modal('hide')
                        }, 1000);
                    }else{
                        toastr.error(data.message)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) { // if error occured
                        data = JSON.parse(jqXHR.responseText);
                        if(data.message == 'The given data was invalid.'){
                            err = data.errors;
                            $.each(err, function(key, val) {
                                $("."+key+"_field .fv-plugins-message-container").text(val);
                                $("."+key+"_field .fv-plugins-message-container").show();
                            });

                            toastr.error(data.message);
                        }
                        else{
                            toastr.error("Error occured. "+jqXHR.status+" "+ textStatus +" "+" please try again");
                        }
                    }
            })
            return false;
        })



    </script>

@endpush
