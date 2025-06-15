@extends('layouts.app')

@section('title', 'Nota ' . $nota->invoice)

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Barang BuyBack & Barang Luar (Toko)</a></li>
        <li class="breadcrumb-item active">#{{ $nota->invoice }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
    @if ($nota->isProcessing() && !auth()->user()->isUserCabang())
        @livewire('goods-receipt.toko.nota.confirm',['nota' => $nota])
    @elseif ($nota->isProcessing() && auth()->user()->isUserCabang())
        @livewire('goods-receipt.toko.nota.waiting-process',['nota' => $nota])
    @elseif ($nota->isSent())
        @livewire('goods-receipt.toko.nota.sent',['nota' => $nota])
    @else
        @livewire('goods-receipt.toko.nota.detail',['nota' => $nota])
    @endif
    </div>
@endsection

@push('page_scripts')
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        let selectedItems = [];
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked
            if(checkbox.checked){
                selectedItems.push(checkbox.value);
            }
        });
        Livewire.emitTo('goods-receipt.toko.nota.confirm', 'selectAllItem', selectedItems)
        });

        window.addEventListener('items:not-selected', event => {
            toastr.error(event.detail.message);
        });

        window.addEventListener('barang-luar:empty-tafsir', event => {
            toastr.error(event.detail.message);
        });

        window.addEventListener('approve:modal', event => {
            $('#approve-modal').modal('show');
        });

        window.addEventListener('edit-tafsir:modal', event => {
            $('#edit-tafsir-modal').modal('show');
        });

        window.addEventListener('barang-luar:updated', event => {
            $('body').removeClass('modal-open');
            $('#edit-tafsir-modal').modal('hide');
            $('.modal-backdrop').remove();
            toastr.success(event.detail.message);
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
            Livewire.emitTo('goods-receipt.toko.nota.confirm', 'isSelectAll', isAllSelected)

        });
    </script>
@endpush

