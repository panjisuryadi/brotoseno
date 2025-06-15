@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">{{ $module_title }}</a></li>
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
                      Penjualan Sales</p>
                        </div>
                        <div id="buttons">


    


                        </div>
                    </div>


<div class="card-body px-1">
<div class="bg-white w-full rounded-lg border border-1 px-3 py-5 mx-auto">
 


<livewire:penjualan-sale.create/>

</div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<x-library.datatable />
@push('page_scripts')
  
@endpush