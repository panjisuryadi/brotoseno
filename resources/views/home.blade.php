@extends('layouts.app')

@section('title', 'Home')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Home</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">

@php
$user = \App\Models\User::findOrFail(Auth::user()->id);
 @endphp



         {{-- @include('vendor.notif') --}}
        @can('show_total_stats')
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                            <i class="bi bi-bar-chart font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-primary">{{ format_currency($revenue) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                           @lang('Revenue')
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                            <i class="bi bi-arrow-return-left font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-warning">{{ format_currency($sale_returns) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                          @lang('Sales Return')
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                            <i class="bi bi-arrow-return-right font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-success">{{ format_currency($purchase_returns) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                            @lang('Purchases Return')
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                            <i class="bi bi-trophy font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-info">{{ format_currency($profit) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                             @lang('Profit')
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan





 @if(Auth::user()->id !== 1)
 @can('access_sortir')
    @include('product::products.sortir_dashboard')
 @endcan

 @can('access_kasir')
    @include('partial.pages.kasir')
 @endcan

 @can('access_kepala_toko')
   @include('partial.pages.kepala_toko')
 @endcan



 @can('access_sales')
   @include('partial.pages.sales')
 @endcan

 @can('access_sales_office')
   @include('partial.pages.office')
 @endcan

  @can('access_page_distribusi')
  @include('partial.pages.distribusi')
  @endcan 

  @can('access_admin_sales')
  @include('partial.pages.admin_sales')
  @endcan

  @can('access_gudang')
  @include('partial.pages.admin_gudang')
  @endcan



 @endif





@include('partial.pages.chart')   

  

 @can('show_logs_dashboard')

<div class="row flex py-0 flex-row grid grid-cols-2 px-3 py-2 gap-2">
    <div class="card border-0 shadow-sm">
        <div class="card-header font-semibold">
            @lang('Log Aktifitas')
        </div>
        <div class="card-body">
          @include('partial.log_user')
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-header font-semibold">
            @lang('Login Record')
        </div>
        <div class="card-body">
              @include('partial.user_login')
        </div>
    </div>
</div>
  @endcan








    </div>
@endsection

@section('third_party_scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js"
            integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@push('page_scripts')
<script src="{{  asset('js/jquery.min.js') }}"></script>
<script src="{{ url('/') }}{{ mix('js/chart-config.js') }}"></script>
@endpush
