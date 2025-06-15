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
</head>

<body class="c-app">
 <script type="text/javascript">
    var base_url = '{{url('/')}}';
  </script>

    @if(! request()->routeIs('app.pos.*')
            && ! request()->routeIs('goodsreceipt.add_products_by_categories')
            && ! request()->routeIs('goodsreceipt.create')
            && ! request()->routeIs('goodsreceipt.show')
            && ! request()->routeIs('goodsreceipt.toko.buyback-barangluar.nota.show')
            && ! request()->routeIs('iventory.type')
            && ! request()->routeIs('distribusitoko.berlian.create')
            && ! request()->routeIs('distribusitoko.emas')
            && ! request()->routeIs('adjustment.cabang.create')
            )
             @include('layouts.sidebar')
            @endif

    <div class="c-wrapper">
            @if(! request()->routeIs('app.pos.*')
            && ! request()->routeIs('purchase.*')
            && ! request()->routeIs('rfid.*')

            )
            <header class="c-header c-header-light c-header-fixed">
                @include('layouts.header')

                  @if(! request()->routeIs('goodsreceipt.add_products_by_categories')
                    && ! request()->routeIs('goodsreceipt.show')
                    && ! request()->routeIs('goodsreceipt.create')

                  )
                    <div class="c-subheader justify-content-between px-3">
                        @yield('breadcrumb')
                        @include('includes.date')
                    </div>
                  @endif


            </header>
            @endif



        <div class="c-body">
            <main class="c-main">
                @yield('content')
            </main>
        </div>

        @include('layouts.footer')
    </div>

    @include('includes.main-js')
</body>
</html>
