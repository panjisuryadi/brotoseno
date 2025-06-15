@extends('layouts.cetak')
@section('title', ''.$module_title.' Details')

@section('content')
<div class="container-fluid">
    @if ($dist_toko->isInProgress())
     @include ("distribusitoko::distribusitokos.cabang.cetak.inprogress")
    @elseif ($dist_toko->isRetur())
      {{-- @livewire('distribusi-toko.cabang.retur',['dist_toko' => $dist_toko]) --}}
        @include ("distribusitoko::distribusitokos.cabang.cetak.retur")
    @elseif ($dist_toko->isCompleted())
        @include ("distribusitoko::distribusitokos.cabang.cetak.completed")
    @elseif ($dist_toko->isDraft())
        @include ("distribusitoko::distribusitokos.cabang.cetak.draft")
    @endif

</div>
@endsection
@push('page_css')
<style type="text/css">
@media (max-width: 767.98px) {
.table-sm th,
.table-sm td {
padding: .3em !important;
}
}
.card-body {
font-size: 0.9rem !important;
}
</style>
@endpush
@push('page_scripts')




@endpush