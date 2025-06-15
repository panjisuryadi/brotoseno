@extends('layouts.app')

@section('title', 'Adjustment Details')

@push('page_css')
    @livewireStyles
@endpush

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('adjustments.index') }}">Adjustments</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right pb-2">
                            <a href="{{route('adjustment.print',$adjustment->id)}}" target="_blank" class="btn btn-primary">Cetak</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>
                                         @lang('Date')
                                    </th>
                                    <th colspan="2">
                                         @lang('Reference')
                                    </th>
                                    <th colspan="2">
                                         @lang('Location')
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        {{ $adjustment->date }}
                                    </td>
                                    <td colspan="2">
                                        {{ $adjustment->reference }}
                                    </td>
                                    <td colspan="2">
                                        {{ $adjustment->cabang->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Stock Data')</th>
                                    <th>@lang('Stock Rill')</th>
                                </tr>
                                @foreach($adjustment->adjustedProducts as $item)
                                    <tr>
                                        <td>{{ $item->product->product_name }}</td>
                                        <td> 1 </td>
                                        <td>{{ $item->status == 1 ? '1' : 0}}</td>
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
