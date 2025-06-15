@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route($module_name.'.index') }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item">{{$detail->name}}</li>
    <li class="breadcrumb-item active">{{$module_action}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route(''.$module_name.'.update', $detail) }}" method="POST" enctype="multipart/form-data">
                        <!-- @csrf -->
                        @csrf
                        @method('patch')

                        <div class="w-full bg-white rounded-lg mx-auto mt-8 flex overflow-hidden rounded-b-none">
                            <div class="w-1/3 bg-gray-100 p-8 hidden md:inline-block">
                                <h2 class="font-bold text-3xl text-gray-700 mb-4 tracking-wide">{{ $detail->name }}</h2>
                                @if ($detail->address)
                                <p class="text-lg text-gray-500 font-medium"> <i class="cil-location-pin"></i> {{ $detail->address }}</p>
                                @endif
                                @if ($detail->phone)
                                <p class="text-lg text-gray-500 font-medium"> <i class="cil-phone"></i> {{ $detail->phone }}</p>
                                @endif
                            </div>
                            <div class="md:w-2/3 w-full">
                                <div class="py-8 px-16">
                                    <label for="target" class="text-sm text-gray-600">Target</label>
                                    <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-indigo-500" type="number" value="{{ formatBerat($detail->target) }}" name="target" step="0.001">
                                    @error('target')
                                    <span class="invalid feedback"role="alert">
                                        <small class="text-danger">{{ $message }}</small>
                                    </span>
                                    @enderror
                                </div>
                                <div class="py-8 px-16 border-t flex justify-between">
                                    <div></div>
                                    <div class="form-group">
                                        <a class="px-5 btn btn-outline-danger"
                                            href="{{ route($module_name.'.index') }}">
                                        @lang('Cancel')</a>
                                        <button class="px-5 btn  btn-submit btn-outline-success">
                                            @lang('Save')
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection