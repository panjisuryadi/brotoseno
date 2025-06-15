@extends('layouts.app')

@section('title', 'POS')

@section('third_party_stylesheets')

@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">POS</li>
    </ol>
@endsection

@push('page_css')
<style type="text/css">
 
.c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 0.3rem;
}

</style>
@endpush

@section('content')
<div class="container-fluid">
<div class="card max-h-screen">
<div class="flex flex-row lg:max-h-screen mt-1">
 <div class="w-3/5 px-2 py-2">

  <livewire:pos.product-list :categories="$product_categories"/>
   
 </div>
 <div class="w-2/5 mt-2 border-l">
   
    <livewire:pos.checkout :cart-instance="'sale'" :customers="$customers"/>
 </div>
 
</div>
</div>

    </div>
@endsection





@push('page_scripts')
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>        
        $(document).ready(function () {
            // $('#checkoutModal').modal('show');
            window.addEventListener('showCustomModal', event => {
                $('#customModal').modal('show');
            });
            window.addEventListener('showCheckoutModal', event => {
                $('#checkoutModal').modal('show');

                // $('#paid_amount').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: false,
                //     precision: 0,
                // });  

                // $('#discount').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: false,
                //     precision: 0,

                // });

                // $('#total_amount').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     precision: 0,
                //     allowZero: false,
                // });

                //  $('#grand_total').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });
                 
                //  $('#final').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });

                //  $('#input_tunai').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });

                //  $('#input_cicilan').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });


                // $('#paid_amount').maskMoney('mask');
                // $('#total_amount').maskMoney('mask');
                // $('#grand_total').maskMoney('mask');
                // $('#discount').maskMoney('mask');
                // $('#final').maskMoney('mask');

                // $('#checkout-form').submit(function () {
                //     var paid_amount = $('#paid_amount').maskMoney('unmasked')[0];
                //     $('#paid_amount').val(paid_amount);

                //     var total_amount = $('#total_amount').maskMoney('unmasked')[0];
                //     $('#total_amount').val(total_amount); 

                //     var discount = $('#discount').maskMoney('unmasked')[0];
                //     $('#discount').val(discount);
                // });
            });
            window.addEventListener('cart:empty', event => {
                toastr.error(event.detail.message);
            });
            window.addEventListener('total_payment_amount', event => {
                toastr.error(event.detail.message);
            });
        });
    </script>

@endpush
