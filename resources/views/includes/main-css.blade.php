<!-- Dropezone CSS -->
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
<!-- CoreUI CSS -->
<link rel="stylesheet" href="{{ url('/') }}{{ mix('css/backend.css') }}" crossorigin="anonymous">
<link rel="stylesheet" href="{{ url('/') }}{{ mix('css/app.css') }}" crossorigin="anonymous">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@yield('third_party_stylesheets')

@livewireStyles

@stack('page_css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');
</style>
<style>

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
button:focus {
    outline: 1px dotted;
    opacity:50%;
    /* outline: 5px auto -webkit-focus-ring-color; */
}

.poppins {
    font-family: 'Poppins', sans-serif !important;
    line-height: 1.5 !important;
   }
/*dropdown aktif background*/
.c-sidebar .c-sidebar-nav-dropdown.c-show {
    background: {{settings()->bg_dropdown_aktif}} !important;
  
}

.hokkie {
    color: #FF9800 !important;
    letter-spacing: 0.2rem;
   }

.btn-jsr {
    color: {{settings()->btn_color}} !important;
    letter-spacing: 0.2rem;
   }

   .border-jsr {
    border-color:{{settings()->btn_color}} !important;
   
   }


.c-header {
   
     background: {{settings()->bg_header_top}} !important;
    border-bottom: 1px solid #d8dbe0;
}




.c-header .c-header-nav .c-header-nav-link, .c-header .c-header-nav .c-header-nav-btn {
    color: {{settings()->link_header_top}} !important;
   
}

.c-header .c-header-toggler {
    color: {{settings()->link_header_top}} !important;
    border-color: rgba(0, 0, 21, 0.1);
}


.c-header .online {
    color: {{settings()->link_header_top}} !important;
  
}




.c-footer {
    color: {{settings()->link_footer}} !important;
    background: {{settings()->bg_footer}} !important;
    border-top: 1px solid #d8dbe0;
}

.c-sidebar .c-sidebar-minimizer {
    background: transparent !important;
}
.c-sidebar .c-sidebar-brand {
    color: #fff;
    background: transparent !important;
}

.c-sidebar {
    color: {{settings()->link_color}} !important;
    background:{{settings()->bg_sidebar}} !important;
}
.c-sidebar-nav-link .c-sidebar-nav-dropdown-toggle {
    color: #000 !important;
}


@media (hover: hover), (-ms-high-contrast: none)
.c-sidebar .c-sidebar-nav-link:hover, .c-sidebar .c-sidebar-nav-dropdown-toggle:hover {
    color: {{settings()->bg_sidebar_link_hover}} !important;
   background:{{settings()->bg_sidebar_hover}} !important;
}

.c-sidebar .c-sidebar-nav-link .c-sidebar-nav-icon, .c-sidebar .c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon {
 color: {{settings()->bg_sidebar_link}} !important;
}


.c-sidebar .c-sidebar-nav-title {
    color: {{settings()->bg_sidebar_link}} !important;
}




.c-sidebar .c-sidebar-nav-link.c-active, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle {
 color: {{settings()->bg_sidebar_link_hover}} !important;
  background: rgba(255, 255, 255, 0.05);
}

.c-sidebar .c-sidebar-nav-link.c-active .c-sidebar-nav-icon, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon {
   color: {{settings()->bg_sidebar_link_hover}} !important;
}
.c-sidebar .c-sidebar-nav-link, .c-sidebar .c-sidebar-nav-dropdown-toggle {
    color: {{settings()->bg_sidebar_link}} !important;
    background: transparent;
}

.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: {{settings()->btn_color}} !important;
    border-color: {{settings()->btn_color}} !important;
}

.c-sidebar .c-sidebar-nav-link.c-active, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle {
  color: #fff;
  background-color: {{settings()->bg_sidebar_aktif}} !important;
}
.c-sidebar .c-sidebar-nav-link.c-active .c-sidebar-nav-icon, .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon {
  color: {{settings()->bg_sidebar_link_hover}} !important;
}
.c-sidebar .c-sidebar-nav-link:focus, .c-sidebar .c-sidebar-nav-dropdown-toggle:focus {
  outline: none;
}


@media (hover: hover), (-ms-high-contrast: none) {
  .c-sidebar .c-sidebar-nav-link:hover, .c-sidebar .c-sidebar-nav-dropdown-toggle:hover {
     color: {{settings()->bg_sidebar_link_hover}} !important;
    background: {{settings()->bg_sidebar_hover}} !important;
  }
  .c-sidebar .c-sidebar-nav-link:hover .c-sidebar-nav-icon, .c-sidebar .c-sidebar-nav-dropdown-toggle:hover .c-sidebar-nav-icon {
    color: {{settings()->bg_sidebar_link_hover}} !important;
  }
  .c-sidebar .c-sidebar-nav-link:hover.c-sidebar-nav-dropdown-toggle::after, .c-sidebar :hover.c-sidebar-nav-dropdown-toggle::after {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 11 14'%3E%3Cpath fill='%23fff' d='M9.148 2.352l-4.148 4.148 4.148 4.148q0.148 0.148 0.148 0.352t-0.148 0.352l-1.297 1.297q-0.148 0.148-0.352 0.148t-0.352-0.148l-5.797-5.797q-0.148-0.148-0.148-0.352t0.148-0.352l5.797-5.797q0.148-0.148 0.352-0.148t0.352 0.148l1.297 1.297q0.148 0.148 0.148 0.352t-0.148 0.352z'/%3E%3C/svg%3E");
  }
}


.w-1p {
     width: 1% !important;
}
.w-2p {
     width: 2% !important;
}.w-3p {
     width: 3% !important;
}.w-4p {
     width: 4% !important;
}
.w-5p {
     width: 5% !important;
}.w-10p {
     width: 10% !important;
}
.w-15p {
     width: 15% !important;
}
.w-20p {
     width: 20% !important;
}

.w-25p {
     width: 25% !important;
}
.w-30p {
     width: 30% !important;
}.w-35p {
     width: 35% !important;
}

.custom-control-input:checked ~ .custom-control-label::before {
    color: #fff;
    border-color: {{settings()->btn_color}} !important;
    background-color: {{settings()->btn_color}} !important;
}

.btn-danger {
    color: #fff;
    background-color: {{settings()->btn_cancel}} !important;
    border-color: {{settings()->btn_cancel}} !important;
}

.btn-primary {
    color: #fff;
    background-color: {{settings()->btn_color}} !important;
    border-color: {{settings()->btn_color}} !important;
}

.btn-success {
    color: #fff;
    background-color: #4caf50 !important;
    border-color: #321fdb !important;
}

.btn-outline-secondary {
    color: #858688 !important;
    border-color: #929599 !important;
}

.small {
    font-size:0.6rem !important;

}

.btn-sm, .btn-group-sm > .btn {
    padding: 0.16rem 0.5rem !important;
    font-size: 0.7rem !important;
    line-height: 1.6 !important;
    border-radius: 0.2rem;
}



.btn-xs, .btn-group-xs > .btn {
    padding: 0.16rem 0.3rem !important;
    font-size: 0.6rem !important;
    line-height: 1.5 !important;
    border-radius: 0.2rem;
}

.text-xs {
    font-size: 0.65rem !important;
    line-height: 1rem !important;
}

.text-jsr {
    color: #ee0086 !important;
   
}

.table-sm td {
    padding: 0.3rem 0.5rem 0.3rem 0.5rem!important;
   
     font-size: 0.8rem !important;
}


.table-sm th {
    padding: 0.5rem 0.3rem 0.5rem 0.3rem!important;
   
     font-size: 0.8rem !important;
}



@media (max-width: 767.98px) { 
 .table-sm th,
 .table-sm td {
      padding: 0.3rem 0.5rem 0.3rem 0.5rem!important;
      font-size: 0.8rem !important;
  }
}


.c-main > .container-fluid, .c-main > .container-sm, .c-main > .container-md, .c-main > .container-lg, .c-main > .container-xl, .c-main > .container-xxl {
    padding-right: 13px !important;
    padding-left: 13px !important;
}
.c-main {
      padding-top: 0.9rem !important;
}


.c-sidebar-nav-dropdown .c-sidebar-nav-dropdown-items {
    padding-left: 0.5rem;
}

.break{
    -ms-word-break: break-all !important;
    word-break: break-all !important;

 /* Non standard for webkit */
     word-break: break-word !important;

    -webkit-hyphens: auto;
       -moz-hyphens: auto;
        -ms-hyphens: auto;
            hyphens: auto;
}

[x-cloak] { display: none !important; }


</style>
