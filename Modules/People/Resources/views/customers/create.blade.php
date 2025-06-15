@extends('layouts.app')
@section('title', 'Create Customer')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
                <div class="form-group">
                    <button class="btn btn-primary">{{ __('Add Customer') }}<i class="bi bi-check"></i></button>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-row grid grid-cols-2 gap-2">
                            
                            <div class="border-right px-2">
                                <div class="form-group">
                                    <label for="customer_name">{{ __('Customer Name') }}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="customer_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="customer_email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" name="customer_email">
                                </div>
                                <div class="form-group">
                                    <label for="country">{{ __('Country') }} </label>
                                    <input type="text" class="form-control" name="country">
                                </div>
                            </div>
                            
                            <div class="px-2">
                                <div class="form-group">
                                    <label for="customer_phone">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="customer_phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="city">{{ __('City') }}</label>
                                    <input type="text" class="form-control" name="city">
                                </div>
                                <div class="form-group">
                                    <label for="address">{{ __('Address') }}</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection