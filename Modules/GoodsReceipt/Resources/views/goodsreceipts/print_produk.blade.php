@extends('layouts.print')
@section('title', $module_title)

@section('content')
<div class="container-fluid w-full">

<div class="flex items-center justify-center mx-auto bg-white grid grid-cols-3 gap-4">
    {{-- {{$pembelian->code}} --}}
  @foreach($detail as $barcode)
    {{-- {{ route('goodsreceipt.show', encode_id($pembelian->id)) }} --}}
<div class="no-underline cursor-pointer p-2 text-center items-center">
    <div class="mt-3 mb-1" style="font-size: 15px;color: #000;">
        {{ $barcode->product_name }}
    </div>
    <div class="flex items-center justify-center">
        {!! QrCode::generate($barcode->product_code); !!}
    </div>
    <p style="font-size: 15px;color: #000;">
        Price:: {{ format_currency($barcode->product_price) }}
    </p>
</div>

    @endforeach
</div>


           
    
</div>



@endsection

@push('page_scripts')
  
@endpush