@extends('layouts.app')
@section('title', 'Products')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style type="text/css">
div.dataTables_wrapper div.dataTables_filter input {
margin-left: 0.5em;
display: inline-block;
width: 220px !important;
}
div.dataTables_wrapper div.dataTables_length select {
width: 70px !important;
display: inline-block;
}
</style>
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="flex flex-wrap -m-4 text-center">
        @foreach(\Modules\Product\Entities\Category::all() as $category)
        <div onclick="location.href='{{ route('products.create') }}';" class="cursor-pointer p-4 md:w-1/4 sm:w-1/2 w-full">
            <div class="justify-center items-center border-2 border-yellow-500 bg-white  px-4 py-6 rounded-lg transform transition duration-500 hover:scale-110">
                <div class="justify-center text-center items-center">
                    <?php
                    if ($category->image) {
                    $image = asset(imageUrl() . $category->image);
                    }else{
                    $image = asset('images/logo.png');
                    }
                    ?>
                    <img id="default_1" src="{{ $image }}" alt="images"
                    class="h-16 w-16 object-contain mx-auto" />
                </div>
                <div class="leading-tight">{{ $category->category_name }}</div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between pb-3 border-bottom">
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                Add Product <i class="bi bi-plus"></i>
                            </a>
                        </div>
                        <div id="button"></div>
                    </div>
                    <div class="table-responsive w-full mt-2">
                        {!! $dataTable->table() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page_scripts')
{!! $dataTable->scripts() !!}
<script type="text/javascript">
</script>
@endpush