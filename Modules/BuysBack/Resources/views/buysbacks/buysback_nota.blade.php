@extends('layouts.app')
@section('title', 'Create Buys Back')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("buysback.index") }}">{{__('Buys Back')}}</a></li>
    <li class="breadcrumb-item active">Buys Back Nota</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    @livewire('buysback.nota.create')
</div>
@endsection

@push('page_scripts')


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
        Livewire.emitTo('buysback.nota.create', 'selectAllItem', selectedItems)
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
        Livewire.emitTo('buysback.nota.create', 'isSelectAll', isAllSelected)
        
    });

</script>



@endpush

    @push('page_css')
        <style type="text/css">
        @media (max-width: 767.98px) { 
         .table-sm th,
         .table-sm td {
             padding: .4em !important;
          }
        }

        table {
                width: 100%;
                margin-bottom: 1rem;
                color: #3c4b64;
                font-size: 0.8rem !important;
            }
        </style>
        @endpush