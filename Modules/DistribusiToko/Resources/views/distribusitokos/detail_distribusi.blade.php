@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    
   <li class="breadcrumb-item active">{{ucfirst($dist_toko->current_status->name)}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    @if ($dist_toko->isInProgress())
        @livewire('distribusi-toko.cabang.detail',['dist_toko' => $dist_toko])
    @elseif ($dist_toko->isRetur())
        @livewire('distribusi-toko.cabang.retur',['dist_toko' => $dist_toko])
    @elseif ($dist_toko->isCompleted())
        @livewire('distribusi-toko.cabang.completed',['dist_toko' => $dist_toko])
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        let selectedItems = [];
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked
            if(checkbox.checked){
                selectedItems.push(checkbox.value);
            }
        });
        Livewire.emitTo('distribusi-toko.cabang.detail', 'selectAllItem', selectedItems)
    });

    window.addEventListener('items:not-selected', event => {
        toastr.error(event.detail.message);
    });

    window.addEventListener('summary:modal', event => {
        $('#summary-modal').modal('show');
    });

    window.addEventListener('check:all-selected', event => {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        let isAllSelected = true;
        checkboxes.forEach(checkbox => {
            if(!checkbox.checked){
                isAllSelected = false;
                return;
            }
        });
        Livewire.emitTo('distribusi-toko.cabang.detail', 'isSelectAll', isAllSelected)
        
    });
    
</script>


@endpush