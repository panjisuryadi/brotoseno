@extends('layouts.app')
@section('title', 'Distribusi Sales')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Distribusi Sales</a></li>
    <li class="breadcrumb-item active">{{ $type }}</li>
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
                      Distribusi  {{ $type }}</p>
                        </div>
                        <div id="buttons">


    <div class="dropdown show">
                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pilih Distribusi
                </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" 
                        href="{{route('iventory.type',[
                                 'kategori'=>encode_id($mainkategori->id),
                                 'type'=>'toko']
                                 )}}">Toko</a>


                        <a class="dropdown-item"
                         href="{{route('iventory.type',[
                                 'kategori'=>encode_id($mainkategori->id),
                                 'type'=>'sales']
                                 )}}">Sales</a>
                    </div>
            </div>


                        </div>
                    </div>


<div class="card-body px-1">
<div class="bg-white w-full rounded-lg border border-1 px-3 py-5 mx-auto">
 


<livewire:product.sales/>

{{-- 


    <table class="w-full text-left mb-3 table table-bordered p-3">
        <thead>
            <tr>
   <th class="text-gray-700 font-bold uppercase py-2">No</th>
      <th class="text-gray-700 font-bold uppercase py-2">Code</th>
      <th class="text-gray-700 font-bold uppercase py-2">NO Nota</th>
      <th class="text-gray-700 font-bold uppercase py-2">Berat Kotor</th>
      <th class="text-gray-700 font-bold uppercase py-2">Berat Bersih</th>
      <th class="text-gray-700 font-bold uppercase py-2">kadar</th>
      <th class="text-gray-700 font-bold uppercase py-2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="py-4 text-gray-700">1</td>
                <td class="py-4 text-gray-700">PO-0004</td>
                 <td class="py-4 text-gray-700">DE9800</td>
                <td class="py-4 text-gray-700">900.87</td>
                <td class="py-4 text-gray-700">899.90</td>
                <td class="py-4 text-gray-700">28</td>

                <td class="py-4 text-gray-700">9800</td>
            </tr>

        </tbody>
    </table>
 --}}



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