@extends('layouts.app')

@section('title', 'Stock Transfer Details')

@push('page_css')
    @livewireStyles
@endpush

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('stocktransfer.index') }}">Stock Transfer</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table>
                                <tr>
                                    <th>
                                         @lang('Date')
                                    </th>
                                    <th>
                                         @lang('Reference')
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $transfer->date }}
                                    </td>
                                    <td>
                                        {{ $transfer->reference }}
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table class="table table-bordered">
                                <tr>
                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Origin')</th>
                                    <th>@lang('Destination')</th>
                                    <th>@lang('Stock Sent')</th>
                                </tr>

                                @foreach($transfer->transferdetail as $detail)
                                    <tr>
                                        <td>{{ $detail->product->product_name }} {{ $detail->product->product_code }}</td>
                                        <td>{{ $detail->origins->name }}</td>
                                        <td>{{ $detail->destinations->name }}</td>
                                        <td>{{ $detail->stock_sent }} {{$detail->product->product_unit}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
