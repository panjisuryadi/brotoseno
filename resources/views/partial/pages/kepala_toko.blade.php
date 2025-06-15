

<div class="flex gap-1">

  <div class="w-3/4">

  @can('dashboard_kepala_toko')
  <div class="flex flex-row grid grid-cols-3 gap-2 mt-1">
<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>

            <div class="text-value text-primary">{{ \Modules\DistribusiToko\Models\DistribusiToko::whereIn('status_id',[2])->count() }}</div>
          <div class="text-muted text-uppercase font-weight-bold">
              In Progresss
            </div>
           <div class="small text-green-400 text-uppercase font-weight-bold">
           Distribusi Toko
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
            {{ \Modules\BuysBack\Models\BuyBackNota::count() }}
           </div>
            <div class="text-muted text-uppercase font-weight-bold">
             BuyBack Nota
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
                {{ \Modules\BuysBack\Models\BuysBack::count() }}
            </div>
            <div class="text-muted text-uppercase font-weight-bold">

           Buys Back
            </div>

        </div>
    </div>
</div>



</div>
@endcan

{{-- {{ auth()->user() }} --}}
<div class="card">

<div class="card-body">

<div class="flex relative py-2">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-b border-gray-300"></div>
  </div>
  <div class="relative flex justify-left">
    <span class="bg-white pl-0 pr-3  text-sm uppercase tracking-wider font-semibold text-dark">
    Dashboard Kepala Toko
   </span>
  </div>
</div>
 <?php 
        if (!$paging) {
            $paging = 'buysbacks';
        }
    ?>
{{-- nav  tab --}}

    <ul class="nav nav-tabs py-1" role="tablist">

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
            <a class="nav-link {{ $paging == 'stockpending' ? 'active' : '' }}" data-toggle="tab" href="#StockPending">Stok Pending</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $paging == 'stockready' ? 'active' : '' }}" data-toggle="tab" href="#StockReady">Stok Ready</a>
        </li>
    </ul>
{{-- end nav  tab --}}


{{-- start content tab --}}


    <div class="tab-content py-3 mb-2">
 <div id="Buysback" class="container px-0 tab-pane {{ $paging == 'buysbacks' ? 'active' : '' }}">
     @include('partial.pages.tab.buysbacks')
</div>

    <div id="distribusitoko" class="container px-0 tab-pane  
      {{ $paging == 'distribusitoko' ? 'active' : '' }}">
        @include('partial.pages.tab.distribusitoko')
    </div>

  <div id="StockPending" class="container px-0 tab-pane {{ $paging == 'stockpending' ? 'active' : '' }}">
      @include('partial.pages.tab.stockpending')
        </div>

  <div id="Penjualan" class="container px-0 tab-pane {{ $paging == 'sales' ? 'active' : '' }}">
           @include('partial.pages.tab.sales')
        </div>

  <div id="BuysBacNota" class="container px-0 tab-pane {{ $paging == 'buysbacknota' ? 'active' : '' }}">
             @include('partial.pages.tab.buysbacknota') 
        </div>

  <div id="StockReady" class="container px-0 tab-pane {{ $paging == 'stockready' ? 'active' : '' }}">
          @include('partial.pages.tab.stockready')
        </div>

    </div>

{{-- end content tab --}}


</div>

</div>




  </div>



  <div class="w-1/4 card">
@include('partial.pages.user')




<hr class="mt-3">

  </div>
</div>



@section('third_party_stylesheets')

@endsection


@push('page_scripts')


@endpush
