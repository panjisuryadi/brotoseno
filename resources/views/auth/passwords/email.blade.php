<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Send Reset Password Link | {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{ url('/') }}{{ mix('css/app.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('/') }}{{ mix('css/backend.css') }}" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
     <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');
</style>
<style type="text/css">
    body {
    margin: 0;
    overflow-x: hidden;
   font-family: 'Poppins', sans-serif !important;
    font-size: 0.805rem;
    font-weight: 400;
    line-height: 1.5;
    text-align: left;
    color: #3c4b64;
    background-color: #ebedef;
}

.card {border-radius: 0.65rem !important; }
 </style>
</head>
<?php

if (settings()->site_logo) {
            $logo = asset("storage/logo/" .settings()->site_logo);
        }else{
            $logo = asset('images/logo.png');
        }

?>
<body class="c-app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card-group">

      <div class="col-12 d-flex justify-content-center mb-3">
            <img width="260" src="{{ $logo }}" alt="Logo">
        </div>
                <div class="card p-2">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="post" action="{{ url('/password/email') }}">
                            @csrf

                            <h4>Reset Your Password</h4>
                            <p class="text-muted">Enter Email to reset password</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                </div>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}" placeholder="Email">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button    style="background-color: {{settings()->btn_color}} !important;" class="btn btn-block btn-primary" type="submit">
                                        <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CoreUI -->
<script src="{{ url('/') }}{{ mix('js/app.js') }}" defer></script>

</body>
</html>
