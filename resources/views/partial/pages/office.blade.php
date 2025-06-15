@can('dashboard_office')
<div class="flex gap-1">

  <div class="w-3/4">

  <div class="flex flex-row grid grid-cols-3 gap-2 mt-1">  
<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-primary">{{ \Modules\BuyBackSale\Models\BuyBackSale::count() }}</div>
            <div class="text-muted text-uppercase font-weight-bold">
           Buys Back Sales
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
                {{ \Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar::count() }}
            </div>
            <div class="text-muted text-uppercase font-weight-bold">

            Barang Luar Sales
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
    DASHBOARD OFFICE
   </span>
  </div>
</div>

  
    <ul class="nav nav-tabs py-1" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home">BuysBack Sales</a>
        </li>
      
    </ul>

    <div class="tab-content py-3 mb-2">
        <div id="home" class="container px-0 tab-pane active">


            <div class="pt-3">

                    <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('Produk') }}</th>
                            <th>{{ label_case('Customer') }}</th>
                            <th>{{ label_case('weight') }}</th>
                            <th>{{ label_case('nominal') }}</th>
                        </tr>
                      @forelse(\Modules\BuyBackSale\Models\BuyBackSale::get() as $row)
                            @if($loop->index > 4)
                                                @break
                                            @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->product_name }}</td>
                            <td>{{ $row->customersale->customer_name }}</td>
                            <td>{{ $row->weight ?? ' - ' }}</td>
                            <td>{{ $row->nominal ?? ' - ' }}</td>
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
 @include('partial.pages.user')
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