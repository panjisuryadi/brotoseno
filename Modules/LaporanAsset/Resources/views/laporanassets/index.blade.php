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
        <livewire:reports.assets-report />
    </div>
</div>
@endsection

<x-library.datatable />
@push('page_scripts')

<script type="text/javascript">
    jQuery.noConflict();
    (function( $ ) {
    $(document).on('click', '#reset-report', function(e){
        if (confirm('Apakah anda yakin akan mereset data report bulan ini?')) {
            Livewire.emit('resetReport')
        }
    });
    })(jQuery);
</script>

@endpush