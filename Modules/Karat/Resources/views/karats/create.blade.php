@extends('layouts.app')
@section('title', 'Create Karat')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("karat.index") }}">Karat</a></li>
    <li class="breadcrumb-item active">Add</li>
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
                       <p class="uppercase text-lg text-gray-600 font-semibold">
                      Karat Emas</p>
                        </div>
                        <div id="buttons">


    


                        </div>
                    </div>


<div class="card-body px-1">
<div class="bg-white w-full rounded-lg border border-1 px-3 py-5 mx-auto">
 


<livewire:karat.create />

</div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection