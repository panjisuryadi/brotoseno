@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('penjualansale.index') }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item active">{{$detail->invoice_no}}</li>
</ol>
@endsection
@section('content')

@push('page_css')
<style type="text/css">
.c-main {
    padding-top: 0.5rem!important;
}
.table th, .table td {
    padding: 0.5rem !important;
    vertical-align: top;
    border-top: 1px solid;
    border-top-color: #d8dbe0;
}


.checkbox {
  position: relative;
}

.checkbox [type="checkbox"] {
  position: absolute;
  visibility: hidden;
  pointer-events: none;
}

.checkbox [type="checkbox"] + label {
  position: relative;
  display: block;
  width: 15px;
  height: 15px;
  border: 2px solid;
  cursor: pointer;
  border-radius: 2px;
  will-change: color;
  transition: .2s color ease-in-out;
}

table thead .checkbox [type="checkbox"] + label:hover,
table thead .checkbox [type="checkbox"] + label:hover:after {
  color: #e73e9d;
}

table tbody .checkbox [type="checkbox"] + label:hover,
table tbody .checkbox [type="checkbox"] + label:hover:after {
  color: #701347;
}

.checkbox [type="checkbox"] + label:after {
  content: '';
  position: absolute;
  width: 5px;
  height: 12px;
  top: 60%;
  left: 50%;
  border-bottom: 2px solid;
  border-right: 2px solid;
  margin-top: -2px;
  opacity: 0;
  transform: translate(-50%, 0%) rotate(45deg) scale(.75);
  will-change: opacity, transform, color;
  transition: .17s opacity ease-in-out, .2s transform ease-in-out, .2s color ease-in-out;
}

.checkbox [type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: translate(-50%, -50%) rotate(45deg) scale(1);
}

.dataTables_wrapper .dataTables_processing {
position: absolute;
top: 55% !important;
  background: transparent !important;
  border: none;
  font-weight: bold;
}

</style>
@endpush
<div class="container-fluid">


   <div class="text-lg bg-white flex justify-between w-full px-2 py-3">
        <div class="px-3 py-2">
   
            <div class="mt-3 text-gray-600">No Invoce</div>
            <h3 class="font-medium text-gray-900 uppercase font-medium font-semibold">{{ $detail->invoice_no }}</h3>
        </div>
          <div class="px-6 py-2">

   <div class="flex flex-row justify-end">
        <a class="flex" href="{{ route('penjualansale.index') }}">
            <div class="flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
                <i class="bi bi-house text-gray-600"></i>
            </div>
        </a>
        <a class="flex" target="_blank"
            id="Save"
            href="{{ route(''.$module_name.'.cetak',encode_id($detail->id)) }}">
            <div class="flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
                <i class="bi bi-printer text-gray-600"></i>
            </div>
        </a>
    </div>

      <div class="mt-0 text-gray-600">Sales</div>
         <div class="leading-5 mt-0 font-semibold text-gray-500">{{ $detail->sales->name }}</div>
         <div class="leading-5 text-gray-500">{{ $detail->sales->address }}</div>

        </div>
    </div>


<div class="bg-white grid grid-cols-3 gap-4">

  <div class="text-gray-600 px-2 py-2">
  

<div class="text-sm px-3 py-2 poppins">
 <div class="flex justify-between w-full py-1">
                <p class="text-gray-600">{{ Label_case('tanggal') }}</p>
                <p class="text-gray-900">{{ tanggal($detail->date) }}</p>
            </div>
           <div class="flex justify-between w-full py-1">
                <p class="poppins text-gray-600">{{ Label_case('invoice_no') }}</p>
                <p class="poppins dark:text-gray-300 text-gray-800">{{ $detail->invoice_no }}</p>
            </div>




</div>




  </div>






  <div class="text-gray-600 col-span-2 px-2 py-2 border-l">


       <div class="card-body">


                <div class="flex items-center">
                    <h4
                    class="flex-shrink-0 pr-4 bg-white text-sm leading-5 tracking-wider font-semibold uppercase text-teal-600">
                   Item
                    </h4>
                    <div class="flex-1 border-t-2 border-gray-200">
                    </div>
                </div>

                    <div class="text-gray-600 table-responsive mt-1">

                  

<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th class="text-center">No</th>
      <th class="text-center">Karat</th>
      <th class="text-center">Berat</th>
      <th class="text-center">Harga % / Rp</th>
      <th class="text-center">Jumlah</th>
    </tr>
  </thead>
  <tbody>
    {{-- @dd($detail->detail) --}}

 @foreach($detail->detail as $row)
    @php
      $jumlah = 0;
      $harga = 0;
      if($row->harga_type == 'nominal'){
        $harga =  'Rp. ' .rupiah($row->gold_price);
        $jumlah = 'Rp. '.rupiah($row->nominal);
      }else{
        $harga = $row->harga . ' %';
        $jumlah = formatBerat($row->jumlah) . ' gr';
      }
    @endphp
   <tr>
      <th class="text-center">{{$loop->iteration}}</th>
      <td class="text-center"> {{$row->karat?->label}}</td>
      <td class="text-center"> {{ formatBerat($row->weight) . 'gr' }}</td>
      <td class="text-center"> {{ $harga }}</td>
      <td class="text-center"> {{ $jumlah }} </td>
    
    </tr>
@endforeach

  

  </tbody>
</table>


                    </div>
                </div>



  </div>
</div>




  {{--   {{ $detail }} --}}



</div>


<div id="ModalGroupKategori" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="ModalHeaderGroupkategori"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModalContentGroupKategori"> </div>
         <div class="modal-footer" id="ModalFooterGroupKategori"></div>

        </div>
    </div>
</div>


@endsection

<x-library.datatable />
