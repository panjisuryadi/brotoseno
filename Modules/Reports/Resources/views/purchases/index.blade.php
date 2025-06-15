@extends('layouts.app')

@section('title', 'Purchases Report')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Purchases Report</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <livewire:reports.purchases-report :suppliers="\Modules\People\Entities\Supplier::all()"/>
    </div>
@endsection

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('openInNewTab', function (dataUri) {
            const newTab = window.open();
            newTab.document.write('<html><head></head><body style="margin:0;"><iframe width="100%" height="100%" src="' + dataUri + '"></iframe></body></html>');
        });
    });
</script>
