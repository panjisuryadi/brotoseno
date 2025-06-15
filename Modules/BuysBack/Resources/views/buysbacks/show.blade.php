@extends('layouts.app')

@section('title', 'Buy Back Detail')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('buysback.index') }}">Buys Back</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
    @if ($buyback_nota->isProcessing())
        @livewire('buysback.nota.confirm',['buyback_nota' => $buyback_nota])
    @endif
    </div>
@endsection

        @push('page_css')
        <style type="text/css">
        @media (max-width: 767.98px) { 
         .table-sm th,
         .table-sm td {
             padding: .4em !important;
          }
        }
        </style>
        @endpush

