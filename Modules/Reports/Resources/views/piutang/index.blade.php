@extends('layouts.app')

@section('title', 'Payments Report')

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Piutang Report</li>
</ol>
@endsection

@section('content')
<div class="container-fluid">
    <div wire:id="yfMJMM43Hc1k6S3Klil4">
        <livewire:reports.piutang-report />
    </div>
</div>
@endsection