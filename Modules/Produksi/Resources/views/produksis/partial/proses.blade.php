
@extends('layouts.app')
@section('title', 'Create Produksi')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route("produksi.index") }}">Produksi</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection
@section('content')
    <div class="container-fluid">
        @livewire('produksi.proses',[
            'module_name' => $module_name,
            'module_action' => $module_action,
            'module_title' => $module_title,
            'module_model' => $module_model
        ])
    </div>
@endsection