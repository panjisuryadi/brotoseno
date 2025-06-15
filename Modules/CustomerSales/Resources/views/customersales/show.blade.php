@extends('layouts.app')

@section('title', 'Customer Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customersales.index') }}">Customers</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>{{ __('Konsumen Sales') }} </th>
                                    <td>{{ $customersale->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th> Email</th>
                                    <td>{{ $customersale->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>{{  __('Telepon')  }}</th>
                                    <td>{{ $customersale->customer_phone }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Nama Pasar') }}</th>
                                    <td>{{ $customersale->market }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Negara') }}</th>
                                    <td>{{ $customersale->country }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Alamat') }}</th>
                                    <td>{{ $customersale->address }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

