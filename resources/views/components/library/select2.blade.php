<!-- php artisan make:component library/select2 -->
{{-- <x-library.select2 /> --}}
@push('page_css')
<!-- Select2 Bootstrap 4 Core UI -->
<link href="{{ asset('plugin/select2/select2-coreui-bootstrap4.min.css') }}" rel="stylesheet" />
<style type="text/css">
.select2-container{ width: 100% !important; }
.select2-container--bootstrap .select2-results__option--highlighted[aria-selected] {
    background-color: {{settings()->btn_color}} !important;
    color: #fff;
}
.select2-container--bootstrap .select2-selection--single .select2-selection__rendered {
    color: #6d7781;
    padding: 1px;
    font-size: 0.8rem !important;
}

.select2-container--bootstrap .select2-selection {
    background-color: #fff;
    border: 1px solid #EBEDEF !important;
    color: #5c6873;
    font-size: .872rem;
    border-radius: 0.35rem;
    outline: 0;
}
.select2-container--bootstrap.select2-container--focus .select2-selection, .select2-container--bootstrap.select2-container--open .select2-selection {
    transition: border-color ease-in-out 0.15s,box-shadow ease-in-out 0.15s;
    border-color: #EBEDEF !important;
}
</style>

@endpush

@push('page_scripts')
<!-- Select2 Bootstrap 4 Core UI -->
<script src="{{ asset('plugin/select2/js/select2.min.js') }}" defer></script>
<script>
    jQuery.noConflict();
    (function( $ ) {
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap",
            });
        });
    })(jQuery);
</script>



@endpush