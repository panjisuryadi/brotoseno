@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">Stok Cabang</li>
    <li class="breadcrumb-item active">{{$module_title}} {{ $module_action }}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">

@include('stok::stoks.datatables.pending')

@if (auth()->user()->isUserCabang())
@include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.datatable.nota')
@endif

</div>
@endsection