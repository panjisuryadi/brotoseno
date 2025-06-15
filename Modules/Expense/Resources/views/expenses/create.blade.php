@extends('layouts.app')

@section('title', 'Create Expense')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <form onsubmit="return validateInputs()" id="expense-form" action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button onclick="validateInputs()" class="btn btn-primary">Create <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required readonly value="EXP">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="date">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="category_id">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="" selected>Select Category</option>
                                            @foreach(\Modules\Expense\Entities\ExpenseCategory::all() as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="amount">Masuk <span class="text-danger">*</span></label>
                                        <input id="amount" type="number" class="form-control" name="amount">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="amount_out">Keluar <span class="text-danger">*</span></label>
                                        <input id="amount_out" type="number" class="form-control" name="amount_out">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row" id="form_sale_id">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sale_id">Invoice No <span class="text-danger">*</span></label>
                                        <select name="sale_id" id="sale_id" class="form-control">
                                            <option value="" selected>Select Invoice</option>
                                            @foreach(\Modules\Sale\Entities\Sale::where('status', 'failed')->get() as $item)
                                                <option value="{{ $item->id }}">{{ $item->reference }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="details">Details</label>
                                <textarea class="form-control" rows="6" name="details"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('page_scripts')
    <script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>

        function validateInputs() {
            var amount = $('#amount').val();
            var amount_out = $('#amount_out').val();

            if (amount && amount_out) {
                alert("Anda hanya dapat mengisi salah satu dari Masuk atau Keluar.");
                return false;
            }

            return true;
        }


        var id_kategori_dp = "{{ $id_kategori_dp }}";
        $(document).ready(function () {
            $('#form_sale_id').hide();

            // var amount = $('#amount').val();
            // var amount_out = $('#amount_out').val();

            // $('#amount').maskMoney({
            //     prefix:'{{ settings()->currency->symbol }}',
            //     thousands:'{{ settings()->currency->thousand_separator }}',
            //     decimal:'{{ settings()->currency->decimal_separator }}',
            // });

            // $('#expense-form').submit(function () {
            //     var amount = $('#amount').maskMoney('unmasked')[0];
            //     $('#amount').val(amount);
            // });

            $('#category_id').on('change', function(){
                let current_value = $('option:selected',this).val();
                if(current_value == id_kategori_dp) {
                    $('#form_sale_id').show();
                }else{
                    $('#form_sale_id').hide();
                }
            })
        });
    </script>
@endpush

