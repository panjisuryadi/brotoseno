@extends('layouts.app')

@section('title', 'Edit Product')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection
@push('page_css')

<style type="text/css">
    .dropzone {
        height: 280px !important;
        min-height: 190px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
    }
    .dropzone i.bi.bi-cloud-arrow-up {
        font-size: 5rem;
        color: #bd4019 !important;
    }
   .form-group {
    margin-bottom: 0.5rem !important;
}
</style>
@endpush

@section('content')
    <div class="container-fluid mb-4">
        <form id="product-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('patch')
                    @include('utils.alerts')
 <div class="card">
  <div class="card-body">
<div class="grid grid-cols-3 gap-3">
{{-- kolom 1 --}}
<div class="py-1">

<div x-data="{photoName: null, photoPreview: null}" class="form-group">
      <?php
                $field_name = 'images';
                $field_lable = __($field_name);
                $label = Label_Case($field_lable);
                $field_placeholder = $label;
                $required = '';
                ?>
 <input type="file" name="{{ $field_name }}" accept="image/*" class="hidden" x-ref="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
    ">

     <label for="Image" class="block text-gray-700 text-sm font-bold mb-2 text-center">Image</label>

    <div class="text-center">
            <div class="mt-2" x-show="! photoPreview">
            <img src="{{asset("images/fallback_product_image.png")}}" class="w-80 h-80 rounded-xl m-auto border-dashed border-2 border-gray-600">
        </div>
        <div class="mt-2" x-show="photoPreview" style="display: none;">
            <span class="block w-80 h-80 rounded-xl m-auto border-dashed border-2 border-gray-600" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
            </span>
        </div>
        <button type="button" class="mt-2 btn btn-outline-success" x-on:click.prevent="$refs.photo.click()">
          @lang('Select Image')
        </button>
    </div>

@if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>










</div>



{{-- kolom 2 --}}
<div class="py-1">
<div class="form-group">
    <label class="mb-1" for="product_name">Product Name <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="product_name" required value="{{ $product->product_name }}">
</div>
<div class="form-group">
    <label class="mb-1" for="product_code">Code <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="product_code" required value="{{ $product->product_code }}" readonly>
</div>

</div>

{{-- kolom3 --}}
<div class="py-1">

<div class="form-group">
    <label class="mb-1" for="category_id">Category <span class="text-danger">*</span></label>
    <select class="form-control" name="category_id" id="category_id" required>
        @foreach(\Modules\Product\Entities\Category::all() as $category)
        <option {{ $category->id == $product->category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label for="product_note">Note</label>
    <textarea name="product_note" id="product_note" rows="4 " class="form-control">{{ $product->product_note }}</textarea>
</div>



</div>

</div>


<div class="flex justify-between w-full">
    <div></div>
    <div class="form-group">
        <button class="btn btn-primary">Update Product <i class="bi bi-check"></i></button>
    </div>
</div>
</div>
</div>



        </form>
    </div>
@endsection

@push('page_scripts')
   
@endpush

