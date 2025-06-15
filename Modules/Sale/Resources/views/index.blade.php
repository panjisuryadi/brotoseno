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
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                   <div class="flex justify-between">       
                <p class="uppercase text-lg text-gray-600 font-semibold">
                      Data <span class="text-yellow-500 uppercase">SALES |</span>
                           <span class="text-gray-400 uppercase">{{ $type }}</span>
                  </p>
                  @php
                  $users = Auth::user()->id;
                  @endphp

                  @if($users == 1)
                  <div class="form-group px-4">
                    <select class="form-control form-control-sm select2" data-placeholder="Pilih Cabang" tabindex="1" name="cabang_id" id="cabang_id">
                        <option value="">Pilih Cabang</option>
                           @foreach($cabangs as $k)
                            <option value="{{$k->id}}" {{ old("id") == $k ? 'selected' : '' }}>{{$k->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  @else
                   <p class="uppercase text-lg text-gray-600 font-semibold">
                     &nbsp;| {{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} 
                  </p>
                 
                  @endif
                  </div>  

                        </div>
                        <div class="flex flex-row" id="buttons">

                          <div class="dropdown mr-1">
                                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pilih Type
                                </a>
                           <div 
                          class="dropdown-menu" 
                          aria-labelledby="dropdownMenuLink" 
                          style="margin: 0px;">
 <a href="{{ route("$module_name.index", ['type'=>'tunai']) }}" class="dropdown-item">Tunai</a>
 <a href="{{ route("$module_name.index", ['type'=>'cicilan']) }}" class="dropdown-item">Cicilan</a>
                              </div>
                         </div>



                        </div>
                    </div>
                    <div class="w-full md:overflow-x-scroll lg:overflow-x-auto mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover md:table-sm lg:table-sm table-responsive-sm">
                            <thead>
                                <tr>
 <th style="width: 3%!important;">No</th>
  <th style="width: 7%!important;" class="text-center">{{ __("Date") }}</th>
  <th style="width: 11%!important;" class="text-center">{{ Label_Case('Cabang') }}</th>

  <th style="width: 7%!important;" class="text-center">{{ Label_Case('Invoice') }}</th>
  <th style="width: 10%!important;" class="text-center">{{ Label_Case('Nominal') }}</th>
 <th style="width: 10%!important;" class="text-center">{{ Label_Case('Cara Bayar') }}</th>
 <th style="width: 6%!important;" class="text-center">{{ Label_Case('status') }}</th>
 <th style="width: 8%!important;" class="text-center"> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@livewire('penjualan-sale.dp.bayar')

@endsection

<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
    jQuery.noConflict();
      (function( $ ) {
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
               ajax: {
                  url: "{{ route("$module_name.index_data", ['type'=>$type]) }}",
                  data: function (d) {
                        d.cabang_id = $('#cabang_id').val()
                    }
                },
          
            dom: 'Blfrtip',
            buttons: [
              
                 {
                   text: 'Export Sale',
                   className: 'btn btn-outline-success',
                   action: function ( e, dt, button, config ) {
                    window.location = '{{ route("$module_name.export_sale_excel", 
                        ['type'=>$type]) }}';
                  }        
                },
               {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                }
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {data: 'date', name: 'date'},
                {
                    data: 'cabang', 
                    searchable: false,
                    orderable: false,
                    name: 'cabang'
                },
              
                {data: 'reference', name: 'reference'},
                {data: 'grand_total_amount', name: 'grand_total_amount'},
                {
                    data: 'cara_bayar', 
                    orderable: false,
                    name: 'cara_bayar'
                },
                {
                    data: 'status', 
                    orderable: false,
                    name: 'status'
                },
            

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

        $( document ).ready(function() {
            var idSales;
        });

        $(document).on("click", "#btn-dp", function (e) {

            e.preventDefault();
            var _self = $(this);
            idSales = _self.data('id');
        });

        // A $( document ).ready() block.
        $( document ).ready(function() {
            $(document).on('shown.bs.modal', '#pembayaran_dp', function (e) {
                Livewire.emit('setSaleId', idSales)
            })
        });

    })(jQuery);
    </script>
@endpush