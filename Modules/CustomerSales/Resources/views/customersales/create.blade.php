@extends('layouts.app')
@section('title', 'Create Customer')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('customersales.index') }}">Konsumen Sales</a></li>
    <li class="breadcrumb-item active">{{__("Add")}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('customersales.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                @include('utils.alerts')
                <div class="form-group">
                    <button class="btn btn-primary">{{__('Create')}} Konsumen <i class="bi bi-check"></i></button>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex flex-row grid grid-cols-2 gap-2">
                            
                            <div class="border-right px-2">
                                <div class="form-group">
                                    <label for="customer_name">{{ __('Konsumen Sales') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="customer_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="customer_email">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="customer_email" required >
                                </div>
                            </div>
                            
                            <div class="px-2">
                                <div class="form-group">
                                    <label for="customer_phone">{{  __('Telepon')  }}</label>
                                    <input type="number" min="0" class="form-control" name="customer_phone" >
                                </div>
                                <div class="form-group">
                                    <label for="market">{{ __('Nama Pasar') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="market" required>
                                </div>
                                <div class="form-group">
                                    <label for="country">{{ __('Negara') }}</label>
                                    <input type="text" class="form-control" name="country" >
                                </div>
                                <div class="form-group">
                                    <label for="address">{{ __('Alamat') }}</label>
                                    <input type="text" class="form-control" name="address" >
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