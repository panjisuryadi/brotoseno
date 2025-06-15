@extends('layouts.app')
@section('title', 'Buat Buy Back Sales')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("buybacksale.index") }}">{{__('Buy Back Sales')}}</a></li>
    <li class="breadcrumb-item active">{{ __('Add') }}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    @livewire('buyback-sales.create')
</div>
@endsection

   <x-library.select2 />
    <x-toastr />

@push('page_scripts')
<script type="text/javascript">
 jQuery.noConflict();
(function( $ ) {   
 $('#sup1').change(function() {
            $('#supplier2').toggle();
            $('#supplier1').hide();
        });
        $('#sup2').change(function() {
            $('#supplier1').toggle();
            $('#supplier2').hide();
        });
 })(jQuery);   
</script>
@endpush