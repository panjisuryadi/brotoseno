<link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css"> </head>
 <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
@if(Toastr::message())
   {!! Toastr::message() !!}
@php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
@endphp
@endif