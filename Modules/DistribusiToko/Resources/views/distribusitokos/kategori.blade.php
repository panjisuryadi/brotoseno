@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">{{ $module_title }}</a></li>
    <li class="breadcrumb-item active">{{ $kategori->name }}</li>
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
.form-group {
margin-bottom: 0.5rem !important;
}
</style>
<style type="text/css">
.dropzone {
    height: 280px !important;
    min-height: 190px !important;
    border: 2px dashed #FF9800 !important;
    border-radius: 8px;
    background: #ff98003d !important;
}

.dropzone i.bi.bi-cloud-arrow-up {
    font-size: 5rem;
    color: #bd4019 !important;
}

.loading {
    pointer-events: none;
    opacity: 0.6;
}

.loading:after {
    content: '';
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid #fff;
    border-top-color: transparent;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }

    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
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
                      Distribusi <span class="text-yellow-500">{{ $kategori->name }}</span></p>
                        </div>
                        <div id="buttons">
                            
                        </div>


                    </div>
            
  
                        <div class="flex flex-row">
                            <x-library.alert />
                        </div>
                 
       <script src="{{ asset('js/jquery.min.js') }}"></script>

                    <!-- livewire component -->
                    @livewire('distribusi-toko.create',['categories'=>$categories,'kategori' => $kategori,'cabang' => $cabang])
                </div>
            </div>
        </div>
 

@endsection

<x-library.datatable />
<x-library.select2 />
<x-toastr />
@section('third_party_scripts')
@endsection
 

