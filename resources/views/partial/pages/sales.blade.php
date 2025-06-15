  @can('dashboard_sales')

<div class="flex gap-1">

  <div class="w-3/4">





  <div class="flex flex-row grid grid-cols-3 gap-2 mt-1">  
<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-primary">{{ \Modules\DataSale\Models\DataSale::count() }}</div>
            <div class="text-muted text-uppercase font-weight-bold">
           Data Sales
            </div>

        </div>
    </div>
</div>




<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-success">
            {{ \Modules\ReturSale\Models\ReturSale::count() }}
           </div>
            <div class="text-muted text-uppercase font-weight-bold">
           Retur Sales
            </div>

        </div>
    </div>
</div>

<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-warning">
                {{ \Modules\Stok\Models\StockSales::count() }}
            </div>
            <div class="text-muted text-uppercase font-weight-bold">

           Stock Sales
            </div>

        </div>
    </div>
</div>



</div>



<div class="card">




<div class="card-body">

<div class="flex relative py-2">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-b border-gray-300"></div>
  </div>
  <div class="relative flex justify-left">
    <span class="bg-white pl-0 pr-3  text-sm uppercase tracking-wider font-semibold text-dark">
    Dashboard Sales
   </span>
  </div>
</div>

    
    <ul class="nav nav-tabs py-1" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#dataSales">Data Sales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#sales">Retur Sales</a>
        </li> 

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#BuybackSales">Stok Sales</a>
        </li>
    </ul>

    <div class="tab-content py-3 mb-2">
        <div id="dataSales" class="container px-0 tab-pane active">


            <div class="pt-3">


  <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('Nama') }}</th>
                            <th>{{ label_case('phone') }}</th>
                            <th>{{ label_case('target') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>
                        @forelse(\Modules\DataSale\Models\DataSale::get() as $sale)
                            @if($loop->index > 4)
                                                @break
                                            @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->name }}</td>
                            <td>{{ $sale->phone }}</td>
                            <td>{{ $sale->target ?? ' - ' }}</td>
                          
                            <td>

                               @can('show_sales')
                                    <a href="{{ route("datasale.show",$sale->id) }}"
                                     class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-eye"></i> &nbsp;@lang('Show')
                                    </a>
                                @endcan

                            </td>
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                        
                    </table>




            </div>
        </div>

  <div id="sales" class="container px-0 tab-pane">
            <div class="pt-3">
             <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('No Retur') }}</th>
                            <th>{{ label_case('Sales') }}</th>
                            <th>{{ label_case('weight') }}</th>
                            <th>{{ label_case('nominal') }}</th>
                            <th>{{ label_case('Admin') }}</th>
                        </tr>
                      @forelse(\Modules\ReturSale\Models\ReturSale::get() as $row)
                            @if($loop->index > 4)
                               @break
                            @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->retur_no }}</td>
                            <td>{{ $row->sales->name }}</td>
                            <td>{{ $row->total_weight }}</td>
                            <td>{{ rupiah($row->total_nominal) }}</td>
                            <td>{{ $row->created_by ?? ' - ' }}</td>
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                        
                    </table>

            </div>
        </div>

  <div id="BuybackSales" class="container px-0 tab-pane">
            <div class="pt-3">

                   <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('Sales') }}</th>
                            <th>{{ label_case('karat') }}</th>
                            <th>{{ label_case('Berat') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>
                    @forelse(\Modules\Stok\Models\StockSales::get() as $row)
                            @if($loop->index > 4)
                                                @break
                                            @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->karat?->label }}</td>
                            <td>{{ $row->sales->name }}</td>
                            <td>{{ $row->weight ?? ' - ' }}</td>
                            <td>
                                
                                @can('show_sales')
                                    <a href="{{ route("sales.show",$row->id) }}"
                                     class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-eye"></i> &nbsp;@lang('Detail')
                                    </a>
                                @endcan


                            </td>
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                        
                    </table>







         
            </div>
        </div>





        
    </div>




</div>

</div>




  </div>



  <div class="w-1/4 card">
<div class="card-body">
    <div class="form-group">
        <label for="image">Users Info <span class="text-danger">*</span></label>
        <img style="width: 100px;height: 100px;" class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Profile Image">
        
<div class="flex items-center justify-center">
    <div class="font-weight-bold py-1 px-2 text-lg">{{ ucfirst(auth()->user()->name) }}</div>
   
</div>
<div class="flex items-center justify-center">
    
     <div class="text-gray-500">
      Roles : {{ ucfirst(Auth::user()->roles->first()->name) }} 
    </div>
   
</div>
<div class="flex items-center justify-center">
    
   
    <div class="text-blue-400">
        Cabang : {{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }}
    </div>
</div>

    </div>
</div>




<hr class="mt-3">

  </div>
</div>





@endcan


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
table.dataTable {
    clear: both;
    margin-top: 0.3rem !important;
    margin-bottom: 0.3rem !important;
    max-width: none !important;
    border-collapse: separate !important;
    border-spacing: 0;
}

.table th, .table td {
    padding: 0.3rem !important;
    vertical-align: top;
    border-top: 1px solid;
    border-top-color: #d8dbe0;
}

.table td {
      text-align: center !important;
}

div.dataTables_wrapper div.dataTables_paginate {
    margin: 0;
    white-space: nowrap;
    text-align: right;
    font-size: 0.7rem !important;
}

</style>
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
             ajax: "{{ route("buysback.nota.index_data") }}",
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
                {data: 'invoice', name: 'invoice'},
                {data: 'cabang', name: 'cabang'},
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



    </script>

@endpush