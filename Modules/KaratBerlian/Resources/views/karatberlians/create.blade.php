@extends('layouts.app')
@section('title', 'Create KaratBerlian')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("karatberlian.index") }}">KaratBerlian</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('karatberlian.store') }}" method="POST">
        @csrf
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                   <div class="form-row">
                            <div class="col-lg-12">
                                <div class="form-group">
                          <?php
                            $field_name = 'name';
                            $field_lable = __($field_name);
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
                         <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                        <input type="text" name="{{ $field_name }}"
                        class="form-control {{ $invalid }}"
                         name="{{ $field_name }}"
                         value="{{ old($field_name) }}"
                         placeholder="{{ $field_placeholder }}" {{ $required }}>
                            @if ($errors->has($field_name))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                        class="text-danger">
                                </span>
                            @endif

                                </div>
                            </div>
                        </div>

                           <div class="form-group">
                             <?php
                            $field_name = 'description';
                            $field_lable = __($field_name);
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
            <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <textarea name="{{ $field_name }}"
             placeholder="{{ $field_placeholder }}"
             id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}"></textarea>

               @if ($errors->has($field_name))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                        class="text-danger">
                                </span>
                            @endif
                            </div>

                        <div class="flex justify-between">
                            <div></div>
                            <div class="form-group">
                             <a class="px-5 btn btn-danger"
                            href="{{ route("karatberlian.index") }}">
                            @lang('Cancel')</a>
                                <button type="submit" class="px-5 btn btn-success">@lang('Create')  <i class="bi bi-check"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection