@extends('layouts.app')
@section('title', 'Edit Settings')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Settings</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @include('utils.alerts')
            <div class="card">
                <div
                    style="background-color: {{settings()->header_color}} !important;"
                    class="card-header bg-primary text-white" >
                    <h5 class="mb-0">@lang('General Settings')</h5>
                </div>
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                <div class="card-body">
<ul class="nav nav-tabs py-1" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#tab_2">General</a>
    </li>


     <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab_4">Styles</a>
    </li>

     <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab_3">Parameter</a>
    </li>

</ul>




<div class="tab-content py-3 mb-2">

<div id="tab_2" class="container px-0 tab-pane active">
@include('setting::general')
</div>


<div id="tab_4" class="container px-0 tab-pane">
    <div class="pt-3">
@include('setting::styles')

    </div>
</div>

<div id="tab_3" class="container px-0 tab-pane">
    <div class="pt-3">
@include('setting::parameter')
     </div>
</div>

{{-- <div id="tab_5" class="container px-0  tab-pane">
    <div class="pt-3">
        
        555
    </div>
</div>
 --}}




</div>




{{-- {!! settings()->site_logo !!} --}}



<div class="w-full flex mx-auto justify-between">
<div></div>

<div class="form-group mb-0 justify-end">
    <button type="submit"
    style="background-color: {{settings()->btn_color}} !important;"
    class="btn btn-primary"><i class="bi bi-check"></i> Save Changes</button>
</div>
</div>





                    </form>


                </div>
            </div>
        </div>



   {{--      <div class="col-lg-12">
            @if (session()->has('settings_smtp_message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    <span>{{ session('settings_smtp_message') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            @endif
            <div class="card">
                <div
                    style="background-color: {{settings()->header_color}} !important;"
                    class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mail Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.smtp.update') }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_mailer">MAIL_MAILER <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mail_mailer" value="{{ env('MAIL_MAILER') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_host">MAIL_HOST <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mail_host" value="{{ env('MAIL_HOST') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_port">MAIL_PORT <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="mail_port" value="{{ env('MAIL_PORT') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_mailer">MAIL_MAILER</label>
                                    <input type="text" class="form-control" name="mail_mailer" value="{{ env('MAIL_MAILER') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_username">MAIL_USERNAME</label>
                                    <input type="text" class="form-control" name="mail_username" value="{{ env('MAIL_USERNAME') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_password">MAIL_PASSWORD</label>
                                    <input type="password" class="form-control" name="mail_password" value="{{ env('MAIL_PASSWORD') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="mail_encryption">MAIL_ENCRYPTION</label>
                                    <input type="text" class="form-control" name="mail_encryption" value="{{ env('MAIL_ENCRYPTION') }}">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="mail_from_address">MAIL_FROM_ADDRESS</label>
                                    <input type="email" class="form-control" name="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') }}">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="mail_from_name">MAIL_FROM_NAME <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mail_from_name" value="{{ env('MAIL_FROM_NAME') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit"
 style="background-color: {{settings()->btn_color}} !important;"

                            class="btn btn-primary"><i class="bi bi-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 --}}







    </div>
</div>
@endsection
@push('page_js')
@endpush
@push('page_css')
@endpush