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
                                        {{ $adjustment->location->descriptive_location_type }}
                                    </td>
                                </tr>
                                
                                
                            </table>
                            @foreach($adjustment->stockDP->groupBy('cabang_id') as $cabangId => $items)
                            <h4 class="font-bold uppercase mt-5 mb-3">Cabang : {{$items->first()->cabang->name}}</h4>
                            <table class="table table-bordered">
                                    
                                    
                                    
                                    @foreach ($items as $item )
                                    @php
                                        $lost = 0;
                                        $new = 0;
                                    @endphp
                                    @if($item->pivot->weight_before > $item->pivot->weight_after)
                                    @php
                                        $lost = $lost + ($item->pivot->weight_before - $item->pivot->weight_after);
                                    @endphp
                                    @elseif ($item->pivot->weight_before < $item->pivot->weight_after)
                                    @php
                                        $new = $new + ($item->pivot->weight_after - $item->pivot->weight_before);
                                    @endphp
                                    @endif
                                    <tr>
                                        <th>@lang('Product Name')</th>
                                        <th>@lang('Stock Data')</th>
                                        <th>@lang('Stock Rill')</th>
                                        <th>@lang('Summary')</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $item->karat?->label }}</td>
                                        <td>{{ $item->pivot->weight_before }}</td>
                                        <td>{{ $item->pivot->weight_after }}</td>
                                        <td colspan="2"><span class="text-success">Barang Lebih {{$new}}</span> | <span class="text-danger">Barang Kurang {{$lost}}</span></td>
                                    </tr>
                                    @endforeach
                                    
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
