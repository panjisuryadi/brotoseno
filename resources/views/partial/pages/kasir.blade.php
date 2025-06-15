

<div class="flex gap-1">

  <div class="w-3/4">

{{--  @php
    $role = Auth::user()->roles->first()->name;
    if ($role = 'Kasir') {
      $paging = 'penjualan';
    } 
  @endphp
 {{ $paging }} --}}
  @can('dashboard_pos')

<div class="flex flex-row grid grid-cols-3 gap-2 mt-1">  
   <div class="card border-0 transform hover:scale-110 transition-transform duration-300 cursor-pointer" onclick="window.location.href='{{ route('goodsreceipt.toko.buyback-barangluar.index') }}'"> 
        <div class="card-body p-0 d-flex align-items-center shadow-sm">
            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                <i class="bi bi-bar-chart font-2xl"></i>
            </div>
            <div>
            
                <div class="text-value text-primary font-2xl">
 {{ \Modules\BuysBack\Models\BuysBack::count() }}
                </div>
              <div class="text-muted text-uppercase font-weight-bold">
                  Buys Back
                </div>     
               

            </div>
        </div>
    </div>




<div class="card border-0 transform hover:scale-110 transition-transform duration-300 cursor-pointer" onclick="window.location.href='{{ route('penjualansale.index') }}'">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value font-2xl text-success">
            {{ \Modules\PenjualanSale\Models\PenjualanSale::count() }}
           </div>
            <div class="text-muted text-uppercase font-weight-bold">
            Penjualan Sales
            </div>

        </div>
    </div>
</div>


<div class="card border-0 transform hover:scale-110 transition-transform duration-300 cursor-pointer" onclick="window.location.href='{{ route('app.pos.index') }}'">
    <div class="card-body hover:bg-gray-100 cursor cursor-pointer p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
            <i class="bi bi-cart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-warning font-2xl">
                {{ \Modules\Sale\Entities\Sale::count() }}
            </div>
            <div class="tracking-wider text-muted text-uppercase font-weight-bold">
                POS
            </div>
        </div>
    </div>
</div>

</div>
@endcan


<div class="card">




<div class="card-body">

<div class="flex relative py-2">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-b border-gray-300"></div>
  </div>
  <div class="relative flex justify-left">
    <span class="bg-white pl-0 pr-3  text-sm uppercase tracking-wider font-semibold text-dark">
    Dashboard Kasir  

    <?php 
        if (!$paging) {
            $paging = 'penjualan';
        }
    ?>
    {{-- {{ $paging }} --}}
   </span>
  </div>
</div>

    
    <ul class="nav nav-tabs py-1" role="tablist">


       <li class="nav-item">
            <a class="nav-link {{ $paging == 'penjualan' ? 'active' : '' }}" data-toggle="tab" href="#penjualan">Penjualan</a>
        </li>   



        <li class="nav-item">
            <a class="nav-link {{ $paging == 'buysbacks' ? 'active' : '' }}" data-toggle="tab" href="#Buysback">Buys Back</a>
        </li>

        @can('access_buysback_nota')
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#BuysBacNota">
            Buys Back Nota</a>
        </li> 
        @endcan


        @can('show_distribusi')
        <li class="nav-item">
            <a class="nav-link {{ $paging == 'distribusitoko' ? 'active' : '' }}" data-toggle="tab" href="#distribusitoko">Distribusi Toko</a>
        </li> 
        @endcan

        <li class="nav-item">
            <a class="nav-link {{ $paging == 'penjualansales' ? 'active' : '' }}" data-toggle="tab" href="#penjualanSales">Penjualan Sales</a>
        </li>  

 {{--  

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#barangLuar">Barang Luar</a>
        </li>
  <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#barangBuysBack">Barang Buys Back</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#barangDP">Barang DP</a>
        </li> --}}


    </ul>

    <div class="tab-content py-3 mb-2">


  <div id="penjualan" class="container px-0 tab-pane {{ $paging == 'penjualan' ? 'active' : '' }}">
        @include('partial.pages.tab.penjualan')
  </div>




 <div id="Buysback" class="container px-0 tab-pane {{ $paging == 'buysbacks' ? 'active' : '' }}">
     @include('partial.pages.tab.buysbacks')
  </div>

<div id="distribusitoko" class="container px-0 tab-pane  
      {{ $paging == 'distribusitoko' ? 'active' : '' }}">
        @include('partial.pages.tab.distribusitoko')
    </div>


  <div id="penjualanSales" class="container px-0 tab-pane {{ $paging == 'penjualansales' ? 'active' : '' }}">
            @include('partial.pages.tab.penjualan_sales')
        </div>


{{--   <div id="barangDP" class="container px-0 tab-pane">
            <div class="pt-3">

                  <h1>BARANG DP</h1>

            </div>
    </div>

  <div id="barangLuar" class="container px-0 tab-pane">
            <div class="pt-3">

                  <h1>BARANG LUAR</h1>

            </div>
            </div>

  <div id="barangBuysBack" class="container px-0 tab-pane">
            <div class="pt-3">

                  <h1>BARANG BuysBack</h1>

            </div>
            </div>
 --}}



  <div id="BuysBacNota" class="container px-0 tab-pane">
            <div class="pt-3">

                   <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th class="text-center">{{ label_case('Date') }}</th>
                            <th>{{ label_case('invoice_no') }}</th>
                            <th>{{ label_case('Invoice Series') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('Pic') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>
                    @forelse(\Modules\BuysBack\Models\BuyBackNota::get() as $row)
                                    @if($loop->index > 4)
                                         @break
                                     @endif
                                            {{-- {{ $row }} --}}

                           <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ shortdate($row->date) }}</td>
                                <td>{{ $row->invoice }}</td>
                                <td>{{ $row->invoice_series }}</td>
                                <td>{{ @$row->cabang->name }}</td>
                                <td>{{ @$row->pic->name }}</td>
                            <td>
                                
                                @can('approve_distribusi')
                                <a href="{{ route("sales.show",$row->id) }}"
                                     class="btn btn-outline-success btn-sm">
                                   {{ Label_case('approve_distribusi') }}
                                    </a>
                                @endcan


                            </td>
                        </tr>
                        @empty
                           <tr>
                                <td colspan="6"> <p class="uppercase">Tidak ada Data</p></td>
                            
                            </tr>
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



@section('third_party_stylesheets')
<style type="text/css">
    
.table th, .table td {
    padding: 0.45rem !important;
    vertical-align: top;
    border-top: 1px solid;
    border-top-color: #d8dbe0;
}


</style>
@endsection


@push('page_scripts')

 

@endpush