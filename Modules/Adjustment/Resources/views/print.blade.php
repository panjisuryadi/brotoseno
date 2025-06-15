<html>
    <head>
        <title>{{$adjustment->reference}}</title>
        
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
    </head>
    <body>
        <div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2">
                                @lang('Date')
                        </th>
                        <th colspan="3">
                                @lang('Reference')
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {{ $adjustment->date }}
                        </td>
                        <td colspan="3">
                            {{ $adjustment->reference }}
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Product Name')</th>
                        <th>@lang('Location')</th>
                        <th>@lang('Stock Data')</th>
                        <th>@lang('Stock Rill')</th>
                        <th>@lang('Note')</th>
                    </tr>
                    @foreach ($category as $category)
                        @php
                            $lost = 0;
                            $new = 0;
                        @endphp
                        @foreach($adjustment->adjustedProducts as $adjustedProduct)
                            @if($adjustedProduct->product->category_id == $category->id)
                            <tr>
                                <td>{{ $adjustedProduct->product->product_name }} {{ $adjustedProduct->product->product_code }}</td>
                                <td>{{ $adjustedProduct->location->name }}</td>
                                <td>{{ $adjustedProduct->stock_data }}</td>
                                <td>{{ $adjustedProduct->quantity }}</td>
                                <td>{{ $adjustedProduct->note ?? '-'}}</td>
                            </tr>
                            @if($adjustedProduct->stock_data > $adjustedProduct->quantity)
                            @php
                                $lost = $lost + ($adjustedProduct->stock_data - $adjustedProduct->quantity);
                            @endphp
                            @elseif ($adjustedProduct->stock_data < $adjustedProduct->quantity)
                            @php
                                $new = $new + ($adjustedProduct->quantity - $adjustedProduct->stock_data);
                            @endphp
                            @endif
                            @endif
                        @endforeach
                        <tr>
                            <td colspan="3">{{$category->category_name}}</td>
                            <td colspan="2"><span class="text-success">Barang Lebih {{$new}}</span> | <span class="text-danger">Barang Kurang {{$lost}}</span></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </body>
</html>