@extends('layouts.app')

@section('title', 'Edit Product Category')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product-categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                @include('utils.alerts')
                <div class="card">
                    <div class="card-body">
 <form action="{{ route('product-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')


                                  <div class="form-group">
                                        <label class="font-weight-bold" for="kategori_produk_id">{{ __('Main Category') }}<span class="text-danger">*</span></label>
                                        <select class="form-control" name="kategori_produk_id" id="kategori_produk_id" required>
                                            @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $main)
                                                <option {{ $main->id == $category->kategori_produk_id ? 'selected' : '' }} value="{{ $main->id }}">{{ $main->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                            <div class="form-group">
                                <label class="font-weight-bold" for="category_code">{{ __('Category Code') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="category_code" required value="{{ $category->category_code }}">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="category_name">{{ __('Category Name') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="category_name" required value="{{ $category->category_name }}">
                            </div>




<div x-data="{photoName: null, photoPreview: null}" class="form-group">
      <?php
                $field_name = 'image';
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

     <label for="Image" class="block text-gray-700 text-sm font-bold mb-2 text-center">{{ __('Image') }}</label>

    <div class="text-center">
            <div class="mt-2" x-show="! photoPreview">
            <img src="{{asset("img/harvest/enam.png")}}" class="w-40 h-40 m-auto rounded-full shadow">
        </div>
        <div class="mt-2" x-show="photoPreview" style="display: none;">
            <span class="block w-40 h-40 rounded-full m-auto shadow" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
            </span>
        </div>
        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3" x-on:click.prevent="$refs.photo.click()">
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




  <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }} <i class="bi bi-check"></i></button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

