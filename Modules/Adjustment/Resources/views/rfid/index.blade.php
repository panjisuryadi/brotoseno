@extends('layouts.app')

@section('title', 'Stock')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"> @lang('Scanner RFID')</li>
    </ol>
@endsection

@section('content')
<div class="container-fluid mt-1">
    <div class="row">



        <div class="col-12">


<div class="px-2 flex justify-between mt-1">
    <div class="text-gray-700 text-center"></div>
    <div class="justify-end py-2">
        <button type="submit" class="btn btn-danger">
       Insert Stok Opname <i class="bi bi-check"></i>
        </button>
    </div>
</div>

            <div class="card">



                <div class="flex flex-row p-3 grid grid-cols-2 gap-2 mt-2">
                    <div class="position-relative px-2">
                        <livewire:rfid.create/>
                        </div>
                        <div>
                            <livewire:rfid.list-table :cartInstance="'purchase'"/>
                            </div>

                    </div>


                </div>
            </div>
        </div>
   {{--  @include('adjustment::partials.modal') --}}
@endsection

@push('page_scripts')
<script type="text/javascript">
 setTimeout(function() { $('input[name="rfid"]').focus() }, 1000);
</script>

 <script>
        window.livewire.on('reload', message => {
           // alert('go');
             setTimeout(function() { $('input[name="rfid"]').focus() }, 500);
        });

        // window.livewire.on('addRfid', message => {
        //     alert('go');

        // });

    </script>

@endpush



@push('page_css')
<style type="text/css">
 .c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 0.5rem !important;
}
 </style>

@endpush
