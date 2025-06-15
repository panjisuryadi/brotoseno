@extends('layouts.app')
@section('title', 'Create Purchase')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('buysback.index') }}">Buys Back</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection
@push('page_css')
<style type="text/css">
    .dropzone {
        height: 220px !important;
        min-height: 220px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
    }
    .dropzone i.bi.bi-cloud-arrow-up {
        font-size: 5rem;
        color: #bd4019 !important;
    }
    .c-main {
        flex-basis: auto;
        flex-shrink: 0;
        flex-grow: 1;
        min-width: 0;
        padding-top: 0.7rem !important;
    }
    @media (min-width: 992px)
    .modal-xl {
        max-width: 920px !important;
    }
    #camera{
        width:100% !important;
        height: 240px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
    }
    #results{
        width: 100% !important;
/*height: 240px !important;*/
/* border: 2px dashed #FF9800 !important;*/
border-radius: 8px;
background: #ff98003d !important;
}
</style>
@endpush
@section('content')
<x-library.select2 />
<div class="container-fluid mb-1">
    <div class="card  py-3 px-3">
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex relative py-2">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-left">
                                <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark"><small>Buys Back</small> Toko / Pabrik <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Tambah Produk tipe Pabrik /Toko."></i></span>
                            </div>
                        </div>
                        @include('utils.alerts')
                        <script src="{{  asset('js/jquery.min.js') }}"></script>
                        <form id="purchase-form" action="{{ route('buysback.store') }}" method="POST">
                            @csrf
                            <div class="flex flex-row grid grid-cols-3 gap-1 py-0">
                                <div class="px-0 col-span-2 mb-0 form-group">
                                    <livewire:buysback.buysback/>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="mb-1" for="kode_sales">Code Sales <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ auth()->user()->kode_user }}" class="form-control" name="kode_sales">
                                    </div>
                                </div>
                                <div class="flex flex-row grid grid-cols-3 gap-1 py-0">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required readonly value="PR">
                                    </div>
                                    <div class="form-group">
                                        <div class="py-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                name="supplier" value="1" id="sup1" checked>
                                                <label class="form-check-label" for="sup1">Supplier</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" value="2" type="radio" name="supplier"
                                                id="sup2">
                                                <label class="form-check-label" for="sup2">Non Supplier</label>
                                            </div>
                                        </div>
                                        <div id="supplier1" style="display: none !important;" class="align-items-center justify-content-center">
                                            <input type="text" class="form-control" placeholder="Nama Suplier" name="none_supplier" >
                                        </div>
                                        <div id="supplier2" style="display: block !important;" class="align-items-center justify-content-center">
                                            <select class="form-control select2" name="supplier_id" id="supplier_id" >
                                                @foreach(\Modules\People\Entities\Supplier::all() as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="date">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" required value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <livewire:product-cart :cartInstance="'purchase'"/>
                                    <div class="flex flex-row grid grid-cols-4 gap-2">
                                        <div class="form-group">
                            @php
                            $locations = \Modules\Locations\Entities\Locations::where('name','LIKE','%Pusat%')
                            ->get();
                            @endphp
                                            <label for="">Location</label>
                                            <select name="location_id" class="form-control select2" readonly>
                                                @foreach ($locations as $loc)
                                                <option value="{{ $loc->id }}" selected>{{ $loc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                       <div class="form-group">
                                            @php
                                            $bb = \Modules\JenisBuyBack\Models\JenisBuyBack::get();
                                            @endphp
                                            <label for="jenis_buyback_id">Type BuyBack</label>
                                            <select name="jenis_buyback_id" class="form-control select2" readonly>
                                                @foreach ($bb as $b)
                                                <option value="{{ $b->id }}" selected>{{ $b->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="payment_method" id="payment_method" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="paid_amount">Amount Paid <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="paid_amount" type="text" class="form-control" name="paid_amount" required>
                                                <div class="input-group-append">
                                                    <button id="getTotalAmount" class="btn btn-primary" type="button">
                                                    <i class="bi bi-check-square"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-danger" for="note">Note (If Needed)</label>
                                        <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="flex justify-between mt-3">
                                        <div class="text-gray-700 text-center"></div>
                                        <div class="justify-end py-2">
                                            <button type="submit" class="btn btn-success">
                                            Create Buys Back <i class="bi bi-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ModalKategori" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalHeaderkategori"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="ModalContentKategori"> </div>
                        <div class="modal-footer" id="ModalFooterKategori"></div>
                    </div>
                </div>
            </div>
            <div id="ModalBack" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalHeaderBack"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="ModalContentBack"> </div>
                        <div class="modal-footer" id="ModalFooterBack"></div>
                    </div>
                </div>
            </div>
            @endsection
            @push('page_scripts')
            <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
            <script>
                $('#purchase-form').on('submit',function(e){
                    var total = $('#total_amount').val()
                    var paid = $('#paid_amount').val()
                    console.log(paid)
                })
            </script>
            <script type="text/javascript">
                $('#up1').change(function() {
                    $('#upload2').toggle();
                    $('#upload1').hide();
                });
                $('#up2').change(function() {
                    $('#upload1').toggle();
                    $('#upload2').hide();
                });
            </script>
            <script type="text/javascript">
                jQuery.noConflict();
                (function( $ ) {
                    $(document).ready(function() {
                        $('#getTotalAmount').click(function(){
                            $('#paid_amount').val($('#total_amount').val())
                        });
                        $('#sup1').change(function() {
                            $('#supplier2').toggle();
                            $('#supplier1').hide();
                        });
                        $('#sup2').change(function() {
                            $('#supplier1').toggle();
                            $('#supplier2').hide();
                        });
                    });
                    $(document).on('click', '#Tambah', function(e){
                        e.preventDefault();
                        $('#ModalKategori').modal('hide');
                        $("#ModalKategori").trigger("reset");
                        if($(this).attr('id') == 'Tambah')
                        {
                            $('.modal-dialog').removeClass('modal-lg');
                            $('.modal-dialog').removeClass('modal-sm');
                            $('.modal-dialog').addClass('modal-xl');
                            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case(' Products') }}');
                        }
                        $('#ModalContent').load($(this).attr('href'));
                        $('#ModalGue').modal('show');
                        $('#ModalGue').modal({
                            backdrop: 'static',
                            keyboard: true,
                            show: true
                        });
                    });
                    $(document).on('click', '#openModalKategori', function(e){
                        e.preventDefault();
                        $('#ModalGue').modal('hide');
                        $("#ModalGue").trigger("reset");
                        var dataURL = $(this).attr('data-href');
            //alert(dataURL);
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-xl');
            $('#ModalContentKategori').load($(this).attr('href'));
            $('#ModalHeaderkategori').html('<i class="bi bi-grid-fill"></i> &nbspKategori {{ Label_case(' Products') }}');
            $('#ModalKategori').modal({
                backdrop: 'static',
                keyboard: true,
                show: true
            });
        });
        $(document).on('click', '#BackButton', function(e){
            e.preventDefault();
            $('#ModalGue').modal('hide');
            $("#ModalGue").trigger("reset");
            $('#ModalKategori').modal('hide');
            $("#ModalKategori").trigger("reset");
            var dataURL = $(this).attr('data-href');
            //alert(dataURL);
            $('.modal-dialog').removeClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-lg');
            $('#ModalContentBack').load(dataURL);
            $('#ModalHeaderBack').html('<i class="bi bi-grid-fill"></i> &nbspKategori {{ Label_case(' Products') }}');
            $('#ModalBack').modal('show');
        });
                })(jQuery);
            </script>
            @endpush