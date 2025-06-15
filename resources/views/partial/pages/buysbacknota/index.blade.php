@extends('layouts.app')
@section('title', 'BuysBack Nota')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Buys Back Nota</li>
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
       
 @if(auth()->user()->isUserCabang())
<div class="btn-group btn-group-md">
      @can('create_buysback_nota')
  <a href="{{ route('buysback.buysback_nota') }}" data-toggle="tooltip"
                                 class="btn btn-outline-success btn-md px-3">
                                 <i class="bi bi-plus"></i>
                                 @lang('Buys back Nota')
    </a>
    @endcan


</div>
    @endif


 
                        </div>
                        <div id="buttons">
                        </div>
                    </div>

         
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                    <tr>
                        <th style="width: 3%!important;">No</th>
                        <th style="width: 20%!important;">Produk</th>
                        <th style="width: 22%!important;">Customer</th>
                        <th style="width: 10%!important;">Status</th>
                        <th style="width: 10%!important;">Nominal</th>
              
                     <th style="width: 15%!important;" 
                     class="@if(auth()->user()->can('edit_buybacktoko') || auth()->user()->can('show_buybacktoko') || auth()->user()->can('delete_buybacktoko'))
                               @else
                               no-sort 
                                @endif
                                    text-center">
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
    @livewire('buysback.item.modal.create')
</div>
@endsection

<x-library.datatable />
@push('page_scripts')
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
                    "visible": false,
                }
            ],
           
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("buysback.nota.index_data") }}',
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

                {data: 'nama_produk', name: 'nama_produk'},
                {data: 'no_buy_back', name:  'no_buy_back'},
             
              
                {data: 'status', name: 'status'},
                {data: 'nominal_beli', name: 'nominal_beli'},
              

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

<script type="text/javascript">
function createModal(){
    $('#buyback-create-modal').modal('show');
}
</script>
@endpush