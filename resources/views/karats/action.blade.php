<?php
// use App\Models\Product;
use Modules\Product\Entities\Product;

$product    = Product::where('karat_id', $data->id)
->where('status', '!=', 2)
->where('status_id', '!=', 2)
->count();
?>

@if($product > 0)

<div class="text-center">
<a href="#" onclick="alert('Ada {{$product}} Product Aktif menggunakan karat berikut, kosongkan terlebih dahulu untuk dapat men Edit');"
id=""
data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i> &nbsp;@lang('Edit') Karat
</a>
</div>
    <button type="submit" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" onclick="alert('Ada {{$product}} Product Aktif menggunakan karat berikut, kosongkan terlebih dahulu untuk dapat men Delete');">
        <i class="bi bi-trash"></i> &nbsp;@lang('Delete')
    </button>
@else

<div class="text-center">
<a href="{{ route(''.$module_name.'.edit', $data->id) }}"
id="Edit"
data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i> &nbsp;@lang('Edit') Karat
</a>
</div>

<form action="{{ route('karats.delete', $data->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" onclick="return confirm('Delete Karat?')">
        <i class="bi bi-trash"></i> &nbsp;@lang('Delete')
    </button>
</form>

@endif



<!-- <div class="text-center">
<a href="{{ route('karats.delete', $data->id) }}"
id="Delete"
data-toggle="tooltip"
 class="btn btn-outline-danger btn-sm">
    <i class="bi bi-trash"></i> &nbsp;@lang('Delete') 
</a>
</div> -->

