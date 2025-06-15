@extends('layouts.app')

@section('title', 'Create Gold Distribution')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('distribusitoko.emas') }}">Distribusi Emas</a></li>
        <li class="breadcrumb-item font-bold"></li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-1 relative">
        @livewire('distribusi-toko.emas.create')
    </div>

@endsection



 @push('page_css')
<style>
        html,
        body {
           /* height: 100vh;*/
        }

    .sortir {
        border: 0.2rem solid;
        color: #111827;
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: 0.1rem;
        background-color: #f0f0f0;
        border-style: dashed;
        height: 5rem;
    }


    .sortir:focus {
    background-color: #f3d585;

    }

    </style>
    
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
 @endpush
 @push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


@endpush