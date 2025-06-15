@extends('layouts.app')

@section('title', 'Product Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product-transfer.index') }}">Products Transfer</a></li>
        <li class="breadcrumb-item active">Tracking Products</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">

        <div class="row">
            <div class="col-lg-8">
                <div class="card h-100">




                    <div class="card-body">

                            <ol class="relative border-l mt-4 border-green-400 dark:border-green-700">
                            @forelse ($tracking as $row)
                            <li class="mb-10 ml-4">
                                <div class="absolute w-3 h-3 bg-green-400 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                                <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{!!tgl($row->created_at) !!}</time>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <i class="bi bi-geo-alt"></i>{{ @$row->location->name }}
                                | <span class="text-gray-500 text-xs font-normal">{{ @$row->products->product_name }}
                                | <span class="text-gray-500 text-xs font-normal">{{ @$row->user->name }}</span>


                                | {!!statusTrackingProduk($row->status) !!} 
                                {{--   @if($row->products->status == 1)
                                {!!statusTrackingProduk($row->products->status) !!} 
                                  @endif --}}
                                </span>
                               </h3>
                                <div class="mb-4 text-xs font-normal text-gray-500 dark:text-gray-400">
                                {!!@$row->note !!}</div>
                            </li>
                            @empty
                            <p>No Data</p>
                            @endforelse


                            </ol>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="card h-100">
        @forelse($product->getMedia('images') as $media)
            <img src="{{ $media->getUrl() }}" alt="Product Image" class="w-full h-56 object-cover object-center">
        @empty
            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="Product Image" class="w-full h-56 object-cover object-center">
        @endforelse
                <div class="py-2 px-3">
                    <h1 class="text-xl font-semibold text-gray-800">{{ $product->product_name }}</h1>

                    <div class="flex items-center mt-4 text-gray-700">
                        <i class="bi bi-currency-dollar"></i>
                        <h1 class="px-2 text-md">{{ format_currency($product->product_cost) }}</h1>
                    </div>
                    <div class="flex items-center mt-4 text-gray-700">
                    <i class="bi bi-currency-exchange"></i>
                        <h1 class="px-2 text-md">{{ format_currency($product->product_price) }}</h1>
                    </div>

                </div>

                </div>
            </div>
        </div>
    </div>
@endsection



