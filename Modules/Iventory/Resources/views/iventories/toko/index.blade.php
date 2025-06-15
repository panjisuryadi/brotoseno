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
@push('page_css')
<style type="text/css">
    
.c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 0.2rem !important;
}
</style>

@endpush
<div class="container-fluid">



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                          <p class="uppercase text-lg text-gray-600 font-semibold">
                      Distribusi  {{ $distribusi }}</p>
                        </div>
                        <div id="buttons">
                        </div>
                    </div>


<div class="flex flex-row grid grid-cols-2 gap-1">
    
<div class="py-2 px-2">
    
<div class="flex justify-between mt-3 mb-6">
        <h1 class="text-lg font-bold">Invoice</h1>
        <div class="text-gray-700">
            <div>Date: {{tgl($detail->date)}}</div>
            <div>Invoice #: {{$detail->code}}</div>
        </div>
    </div>

<table class="w-full mb-8 poppins">
        <thead>
            <tr>
                <th class="text-left font-bold text-gray-700">
                {{Label_case('no_invoice')}}</th>
                <th class="text-right font-semibold text-gray-800">
                {{$detail->no_invoice}}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left text-gray-700"> {{Label_case('berat_kotor')}}</td>
                <td class="text-right text-gray-700"> {{$detail->berat_kotor}}</td>
            </tr>
              <tr>
                <td class="text-left text-gray-700"> {{Label_case('supplier_id')}}</td>
                <td class="text-right text-gray-700"> {{$detail->supplier_id}}</td>
            </tr> 

             <tr>
                <td class="text-left text-gray-700"> {{Label_case('Kategori')}}</td>
                <td class="text-right text-gray-700"> {{$detail->kategoriproduk_id}}</td>
            </tr>

             <tr>
                <td class="text-left text-gray-700"> {{Label_case('total_emas')}}</td>
                <td class="text-right text-gray-700"> {{$detail->total_emas}}</td>
            </tr>  

             <tr>
                <td class="text-left text-gray-700"> {{Label_case('tipe_pembayaran')}}</td>
                <td class="text-right text-gray-700"> {{$detail->tipe_pembayaran}}</td>
            </tr>
            
        </tbody>
        <tfoot>
            <tr>
                <td class="text-left font-bold text-gray-700">{{Label_case('Qty')}}</td>
                <td class="text-right font-bold text-gray-700">{{$detail->qty}}</td>
            </tr>
        </tfoot>
    </table>


    {{$detail->pembelian}}

</div>


<div class="px-1 border-l">
    





{{-- {{$detail->goodsreceiptitem}} --}}



<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Kategori</th>
      <th scope="col">Karat</th>
      <th scope="col">Qty</th>
    </tr>
  </thead>
  <tbody>

 @foreach($detail->goodsreceiptitem as $item) 
    <tr>
      <th scope="row">1</th>
      <td>{{$item->kategoriproduk_id}}</td>
      <td>{{$item->karat_id}}</td>
      <td>{{$item->qty}}</td>
    </tr>

@endforeach

  </tbody>
</table>





</div>



</div>







                  {{--   <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                 <th style="width: 6%!important;">No</th>


                     <th style="width: 18%!important;" class="text-center">{{ __('No Nota / Date') }}</th>

                        <th class="text-left">{{ __('Stok Awal') }}</th>
                        <th class="text-left">{{ __('Detail') }}</th>
                        <th class="text-left">{{ __('Stok Akhir') }}</th>

                                    <th style="width: 15%!important;" class="text-center">
                                         {{ __('Distribusi') }}
                                    </th>
                                    <th style="width: 18%!important;" class="text-center">
                                        {{ __('Action') }}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
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
                }
            ],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.index_data") }}',
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
                {data: 'stok_awal', name: 'stok_awal'},
                {data: 'code', name: 'code'},
                {data: 'code', name: 'code'},
                {data: 'distribusi', name: 'distribusi'},
              

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
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush