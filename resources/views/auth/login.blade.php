<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Login | {{ config('app.name') }}</title>

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

.btn-link {
    font-weight: 400;
    color:  {{settings()->link_color}} !important;
    text-decoration: none;
}

.btn-primary {
  background-color: {{settings()->btn_color}} !important;"
  color: white;
  text-decoration: none;
  opacity: 1.0;

}
.btn-primary:hover {
 opacity: 0.5;
  background-color: #333 !important;"
}
.hp {
display: none !important;
}

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

    <div class="row justify-content-center">
        <div class="{{ Route::has('register') ? 'col-md-8' : 'col-md-7' }}">
            @if(Session::has('account_deactivated'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('account_deactivated') }}
                </div>
            @endif
            <div class="card-group">
                <div class="card p-2 border-0 shadow-sm">
                    <div class="card-body py-3">
                        <form method="post" action="{{ url('/login') }}">
                            @csrf


<div class="flex relative py-2">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-b border-gray-300"></div>
  </div>
  <div class="relative flex justify-left">
    <span class="bg-white pl-0 pr-3  text-sm capitalize text-dark">Login to your account</span>
  </div>
</div>


<div class="flex justify-between px-1 py-1 pb-3 border-bottom">

    <div class="w-2/5 flex justify-center items-center">  <img class="items-center object-contain h-32" src="{{ $logo }}" alt="Logo"></div>
    <div class="w-4/5 mt-3">


  <div class="flex py-1">
    <span class="px-3 inline-flex items-center min-w-fit rounded-l-md border border-r-0 border-gray-200 bg-gray-100 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400"> <i class="bi bi-person"></i></span>
    <input type="email" class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light px-3 relative focus:border-blue focus:shadow @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       placeholder="Email">


  </div>
@error('email')
<div class="capitalize small text-red-500">{{ $message }}</div>
@enderror

  <div class="flex py-1 mt-2 relative"  x-data="{ show: true }">
    <span class="px-3 inline-flex items-center min-w-fit rounded-l-md border border-r-0 border-gray-200 bg-gray-100 text-sm text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400"> <i class="bi bi-lock"></i></span>

 <input class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light px-3 relative focus:border-blue focus:shadow @error('password') border-red-200 @enderror" :type="show ? 'password' : 'text'" name="password" id="password" autocomplete="off" type="password" placeholder="Password" name="password">


   <div class="absolute top-1/2 right-4 cursor-pointer" style="transform: translateY(-50%);">
          <svg class="h-4 text-gray-700 block" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
            </path>
          </svg>

          <svg class="h-4 text-gray-700 hidden" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
            <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
            </path>
          </svg>
        </div>


  </div>

@error('password')
<div class="small capitalize text-red-500">{{ $message }}</div>
@enderror

</div>
</div>

                            <div class="row mt-2">
                                <div class="col-4">
                                    <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>

                                  {{--    <a class="btn btn-link px-0" href="{{ route('sso.login') }}">
                                        Login SSO?
                                    </a> --}}
                                </div>
                                <div class="col-8 text-right">
                                    <button
                                    class="btn btn-primary px-5" type="submit">Login</button>
                                </div>





                            </div>
                        </form>
            <div class="mt-1 px-2 flex justify-between text-center text-muted">
                <?php
                $publicIp = getipadress();
                if ($publicIp == '103.171.154.31') {
                $server = 'Server : BDG01';
                } else {
                $server = 'Server : JKT02';
                }
                ?>
                <div></div>
                <div>{{ $server }}</div>
                
            </div>


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
