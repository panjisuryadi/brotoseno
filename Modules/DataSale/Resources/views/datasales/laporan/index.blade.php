@extends('layouts.app')

@section('title', ''.$module_title.' Details')



@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("datasale.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item ">Laporan Sales</li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection


@section('content')
<div class="container-fluid">

    <livewire:reports.laporan-sales/>

</div>

@endsection

@push('page_css')
<style>
    .dt-buttons{
        float: initial !important;
        width: fit-content;
        margin-left: auto;
        margin-bottom: 2rem;
    }
</style>
    
@endpush
<x-library.datatable />
@push('page_scripts')

@endpush