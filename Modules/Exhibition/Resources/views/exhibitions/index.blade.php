@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                 xzxzxz
             
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page_css')
 <style type="text/css">
 .c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 1rem !important;
}

 </style>
@endpush


@push('page_scripts')
 
@endpush