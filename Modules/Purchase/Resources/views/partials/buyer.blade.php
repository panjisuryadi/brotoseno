<div class="justify-center text-center items-center">
@if ($data->customer_name == null)
    <div class="font-semibold relative">
        {{ $data->supplier_name }}
    </div>
@else
    <div class="font-semibold py-1 relative text-blue-500">
       {{--  <span style="font-size: 0.5rem !important;" class="badge badge-warning absolute right-0 top-0 ">Customer</span> --}}
        {{ $data->customer_name }}
    </div>
@endif
</div>