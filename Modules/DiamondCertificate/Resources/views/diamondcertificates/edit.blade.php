@extends('layouts.app')

@section('title', ''.$module_title.' Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
         <li class="breadcrumb-item"><a href="{{ route("diamondcertificate.index") }}">{{$module_title}}</a></li>
        <li class="breadcrumb-item active">{{$module_action}}</li>
    </ol>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

   <form action="{{ route(''.$module_name.'.update', $detail) }}" method="POST">
            @csrf
            @method('patch')

               <div class="form-row">
                            <div class="col-lg-12">
                                <div class="form-group">
                          <?php
                            $field_name = 'name';
                            $field_lable = __("Name");
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
                         <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" value="{{ $detail->name }}" placeholder=" Name" {{ $required }}>
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
                            $field_lable = __("Description");
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
            <label for="{{ $field_name }}">{{ $field_placeholder }}<span class="text-danger">*</span></label>
            <textarea name="{{ $field_name }}" id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}">{{ $detail->description }}</textarea>

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
                            href="{{ route("diamondcertificate.index") }}">
                            @lang('Cancel')</a>
                                <button type="submit" class="px-5 btn btn-success">@lang('Update')</button>
                            </div>
                        </div>
                   </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

