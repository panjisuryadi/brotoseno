
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') || {{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
       <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}">

    @include('includes.main-css')
    @stack('page_css')



</head>

<body class="w-full">

        <div class="c-body">
            <main class="c-main">
                @yield('content')
            </main>
        </div>

     
    </div>

    @include('includes.main-js')
    @stack('page_scripts')
</body>
</html>
