@extends('layouts.app')

@section('title', ''.$module_title.' Details')

@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("datasale.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item ">{{$detail->name}}</li>
    <li class="breadcrumb-item active">{{$module_action}}</li>
</ol>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- component -->
            <div class="px-2 py-1">
                <div class="w-full">
                    <div class="-mx-2 md:grid grid-cols-3 grid-rows-2 mb-4 gap-y-4">
                        <div class="w-full h-full px-2 row-span-2">
                            <div class="h-full rounded-lg shadow-sm">
                                <div class="h-full rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-5 pt-8 pb-10 relative z-10">
                                        <h2 class="font-bold text-3xl text-gray-700 mb-4 tracking-wide"> {{ $detail->name }}</h2>
                                        @if ($detail->address)
                                        <p class="text-lg text-gray-500 font-medium"> <i class="cil-location-pin"></i> {{ $detail->address }}</p>
                                        @endif
                                        
                                        @if ($detail->phone)
                                        <p class="text-lg text-gray-500 font-medium"> <i class="cil-phone"></i> {{ $detail->phone }}</p>
                                        @endif



                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2 relative">
                            <div class="absolute right-5 top-2 z-20">
                                <a id="modal-target" class="btn btn-outline-nfo btn-sm">
                                    <i class="bi bi-pencil"></i> &nbsp;@lang('Update')
                                </a>
                            </div>
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Target Penjualan</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">{{ formatBerat($detail->target) }} gram</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2 relative">
                            <div class="absolute right-5 top-2 z-20">
                                <a id="modal-incentive" class="btn btn-outline-nfo btn-sm">
                                    <i class="bi bi-pencil"></i> &nbsp;@lang('Update')
                                </a>
                            </div>
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Insentif</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">Rp. {{ rupiah($detail->insentif->count()?$detail->insentif->first()->nominal:0) }}</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full px-2">
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Jumlah Penjualan</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">{{ $detail->penjualanSale->sum('total_weight') }} gram</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Total Stock</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">{{ $detail->stockSales->sum('weight') }} gram</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart2" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   
                </div>
                <div class="card">
                    <div class="card-body">
                    <div class="table-responsive mt-1">
                        <table id="penjualan_table" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 3%!important;">No</th>

                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('date') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('store_name') }}</th>
                                    <th style="width: 10%!important;" class="text-center">{{ Label_Case('total_weight') }}</th>
                                    <th style="width: 10%!important;" class="text-center">{{ Label_Case('total_nominal') }}</th>
                                    <th style="width: 10%!important;" class="text-center">{{ Label_Case('created_by') }}</th>

                                    <th style="width: 18%!important;" class="text-center"> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    </div>
                </div>

                <div class="card w-full">
                    <div class="card-body">
                    <div class="table-responsive mt-1">
                        <table id="stock_table" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 3%!important;">No</th>

                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('karat') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('berat') }}</th>

                                    <th style="width: 18%!important;" class="text-center"> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>
@include('datasale::datasales.modal.incentive')
@include('datasale::datasales.modal.target')
@endsection

@push('page_css')
<style>
    .dt-buttons{
        float: initial !important;
        width: fit-content;
        margin-left: auto;
        margin-bottom: 2rem;
    }
</style>
    
@endpush
<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
        $('#penjualan_table').DataTable({
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
            },
            },
            "aaSorting": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.show_data", $detail) }}',
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
                {data: 'store_name', name: 'store_name'},
                {data: 'total_weight', name: 'total_weight'},
                {data: 'total_nominal', name: 'total_nominal'},
                {data: 'created_by', name: 'created_by'},

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



        $('#stock_table').DataTable({
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
            },
            },
            "aaSorting": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.show_stock", $detail) }}',
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

                {data: 'karat', name: 'karat'},
                {data: 'berat', name: 'berat'},

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
</script>

<script>
    $('#modal-target').click(function(){
        $('#modaltarget').modal('show')
    })
    $('#modal-incentive').click(function(){
        $('#modalincentive').modal('show')
    })

    $('#form-incentive').submit(function(){
        $.ajax({
            type: "POST",
            url: '{{route("datasale.updateincentive")}}',
            data: $('#form-incentive').serialize(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept' : 'application/json'
            },
            success: function(data){
                if(data.status == 'success'){
                    toastr.success(data.message)
                    setTimeout(function(){ location.reload();}, 1000);
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
    $('#form-target').submit(function(){
        $.ajax({
            type: "POST",
            url: '{{route("datasale.updatetarget")}}',
            data: $('#form-target').serialize(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept' : 'application/json'
            },
            success: function(data){
                if(data.status == 'success'){
                    toastr.success(data.message)
                    setTimeout(function(){ location.reload();}, 1000);
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