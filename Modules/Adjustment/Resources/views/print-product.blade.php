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
                        <th >
                                @lang('Date')
                        </th>
                        <th colspan="2">
                                @lang('Reference')
                        </th>
                        <th >
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
                        <td>
                            {{ $adjustment->cabang->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Product Name')</th>
                        <th>@lang('Stock Data')</th>
                        <th>@lang('Stock Rill')</th>
                        <th>@lang('Note')</th>
                    </tr>
                    @foreach ($category as $category)
                        @php
                            $kurang = 0;
                            $berhasil = 0;
                            $isShow = 0;
                            foreach($adjustment->adjustedProducts as $adjustedProduct){
                                if($adjustedProduct->product->category_id == $category->id){
                                    $isShow = 1;
                                    if($adjustedProduct->status == 2) {
                                        $kurang += 1;
                                    }else{
                                        $berhasil += 1;
                                    }
                                }
                            }
                        @endphp
                        @if($isShow)
                        <tr>
                            <td>{{$category->category_name}}</td>
                            <td>{{ $berhasil+$kurang }}</td>
                            <td>{{ $berhasil }}</td>
                            <td>
                                <span class="text-success">
                                    Barang berhasil distokopname {{$berhasil}} pcs</span> | <span class="text-danger">Barang Kurang {{$kurang}}
                                </span>
                            </td>
                        </tr>
                        @endif

                    @endforeach
                </table>
            </div>
        </div>
    </body>
</html>