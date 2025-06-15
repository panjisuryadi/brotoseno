@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
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
        <div class="col-12">

<div class="px-0 py-1 grid grid-cols-3 gap-4 m-2 mt-0 mb-2 no-underline">
    
    <div class="bg-white card-body p-0 d-flex align-items-center border shadow">
        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
            <i class="bi bi-currency-dollar text-3xl"></i>
        </div>
        <div>
            <div id="total_nilai_angkat" class="text-value font-semibold text-lg text-success">Rp. {{ number_format($total_nilai_angkat) }}</div>
            <div class="text-gray-600 text-uppercase font-weight-bold text-md">
                TOTAL NILAI ANGKAT
            </div>
        </div>
    </div>
    <div class="bg-white card-body p-0 d-flex align-items-center border shadow">
        <div class="bg-gradient-danger p-4 mfe-3 rounded-left">
            <i class="bi bi-wallet-fill text-3xl"></i>
           
        </div>
        <div>
            <div id="total_berat" class="text-xl font-semibold text-value text-success">{{ $total_berat }} gram</div>
            <div class="text-md text-gray-600 text-uppercase font-weight-bold">
               TOTAL BERAT
            </div>
            <i class="bi bi-suitcase-lg"></i>
        </div>
    </div>
    <div class="bg-white card-body p-0 d-flex align-items-center  border shadow">
        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
            <i class="bi bi-map-fill text-3xl"></i>

        </div>
        <div>
            <div id="cabang_widget" class="text-md font-semibold text-value text-success">Semua Cabang</div>
            <div class="text-gray-600 text-uppercase font-weight-bold text-lg">
        
            </div>
        </div>
    </div>
</div>



            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                           <a href="{{ route(''.$module_name.'.create') }}"
                                id="Add"
                                data-toggle="tooltip"
                                 class="btn btn-outline-secondary uppercase">
                                 <i class="bi bi-plus"></i>
                                 @lang('Tambah Penerimaan Barang Luar')
                                </a>

                             <a href="{{ route(''.$module_name.'.index_insentif') }}"
                                id="Add"
                                data-toggle="tooltip"
                                 class="btn btn-outline-secondary uppercase">
                                 <i class="bi bi-plus"></i>
                                 Insentif
                                </a>

                        </div>
                        <div class="flex gap-x-5">
                            <div class="form-group">
                                <select name="cabang_filter" id="cabang_filter" class="form-control">
                                    <option value="" selected>Semua Cabang</option>
                                    @foreach ($datacabang as $cabang )
                                    <option value="{{$cabang->id}}">{{ $cabang->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div id="buttons">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">No</th>
                                    <th style="width: 9%!important;">No Barang Luar</th>
                                    <th style="width: 10%!important;">Detail Produk</th>
                                    <th style="width: 10%!important;">Nilai Produk</th>
                                   
                             <th style="width: 10%!important;">Status</th>
                                  
                                    <th style="width: 10%!important;" class="text-center">
                                        {{ __('Action') }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include($module_name.'::'.$module_path.'.modal.status')
</div>
@endsection

<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
    $(function(){
        datatable()
        getSummary()
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
            ajax: '{{ route("$module_name.index_data") }}?cabang='+$('#cabang_filter').val(),
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

                {data: 'no_barang_luar', name:  'no_barang_luar'},
                {data: 'nama_produk', name: 'nama_produk'},
                {data: 'nilai', name: 'nilai'},
                {data: 'status', name: 'status'},
            
           

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
    }


    $('#cabang_filter').change(function(){
        datatable()
        $('#cabang_widget').text($('#cabang_filter option:selected').text());
        getSummary()
    })

    function getSummary(){
        $.ajax({
            type: "get",
            url: '{{route("$module_name.getsummary")}}?cabang='+$('#cabang_filter').val(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept' : 'application/json'
            },
            success: function(data){
                $('#total_nilai_angkat').text(data.total_nilai_angkat)
                $('#total_berat').text(data.total_berat)
            }
        })
    }

    function showStatus(data){
        $('#modal-status').modal('show')
        $('#modal-status #data_id').val(data.id)
        $('#modal-status #status_id').val(data.status_id)
    }

    $('#form-status').submit(function(){
        $.ajax({
            type: "POST",
            url: '{{route("penerimaanbarangluar.update_status")}}',
            data: $('#form-status').serialize(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept' : 'application/json'
            },
            success: function(data){
                if(data.status == 'success'){
                    toastr.success(data.message)
                    setTimeout(function(){ 
                        $('#datatable').DataTable().ajax.reload(null, false);
                        $('#modal-status').modal('hide')
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