@extends('layouts.app')

@section('title', 'Purchases')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Purchases</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">


{{-- <div class="flex grid grid-cols-2 gap-4 text-center items-center">
     <div onclick="location.href='{{ route('purchase.type', ['type' => 'NonMember']) }}';" class="cursor-pointer p-4 w-full">
        <div class="justify-center items-center border-2 border-yellow-500 bg-white  px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
        <div class="justify-center text-center items-center">
        <?php
        $image = asset('images/logo.png');
         ?>
      <img id="default_1" src="{{ $image }}" alt="images"
        class="h-16 w-16 object-contain mx-auto" />
        </div class="py-1">
          <div class="leading-tight py-3">Member / Non Member</div>
        </div>
      </div>

     <div onclick="location.href='{{ route('purchase.type', ['type' => 'toko']) }}';" class="cursor-pointer p-4 w-full">
        <div class="justify-center items-center border-2 border-red-500 bg-white  px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
        <div class="justify-center text-center items-center">
        <?php
        $image = asset('images/logo.png');
         ?>
      <img id="default_1" src="{{ $image }}" alt="images"
        class="h-16 w-16 object-contain mx-auto" />
        </div class="py-1">
          <div class="leading-tight py-3">Toko / Gudang</div>
        </div>
      </div>



    </div>

 --}}






        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
<ul class="nav nav-tabs  p-2" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#tab_2">General</a>
    </li>


     <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab_4">Supplier</a>
    </li>

     <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab_5">History</a>
    </li>

</ul>

<div class="tab-content p-2 mb-2">

<div id="tab_2" class="container p-2 tab-pane active">

  @include('purchase::table.all')

</div>


<div id="tab_3" class="container p-2 tab-pane">
    <div class="pt-3">
      @include('purchase::table.customer')
    </div>
</div>

<div id="tab_4" class="container p-2 tab-pane">
    <div class="pt-3">
       @include('purchase::table.supplier')
    </div>
</div>

<div id="tab_5" class="container p-2 tab-pane">
    <div class="pt-3">
       @include('purchase::table.history')
    </div>
</div>





</div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Selesaikan Pembelian</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{route('purchase.completepurchase')}}">
        @csrf
        <div class="modal-body">
            <div id="modal-content">

            </div>
            <input type="hidden" id="purchase_id" name="purchase_id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" >Confirm</button>
        </form>
        </div>
        </div>
    </div>
    </div>
@endsection


@push('page_scripts')


<script>
        function completepurchase(id,noref){
        $('#purchase_id').val(id)
        $('#modal-content').html('Konfirmasi Untuk Menyelesaikan Pembelian '+noref)
        $('#exampleModal').modal('show')
    }
    function confirmcomplete(){
        
    }
</script>
@endpush


