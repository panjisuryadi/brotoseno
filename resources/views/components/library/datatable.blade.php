<!-- php artisan make:component library/Datatable -->
<!-- php artisan make:component library/webcam -->
@push('page_css')
<link rel="stylesheet" href="{{ asset('plugin/datatable/Buttons-2.3.3/css/buttons.min.css') }}">
<style type="text/css">

.datatable  th {
    text-align: center;
    padding: 0.5rem !important;
    font-size: 14px !important;
}

div.dataTables_wrapper div.dataTables_length select {
    width: 80px !important;
    display: inline-block;
}
div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: 21rem !important;
}

.datatable td, .table th {
    font-size: 0.8rem !important;
    padding: 0.6rem !important;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    text-align: center !important;
}


div.dataTables_wrapper div.dataTables_length label {
    font-weight: normal;
    text-align: left;
    white-space: nowrap;
    float: left !important;
    width: 10px;
}

</style>

@endpush

@push('page_scripts')
<script src="{{ asset('plugin/datatable/DataTables-1.13.1/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('plugin/datatable/DataTables-1.13.1/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('plugin/datatable/JSZip-2.5.0/jszip.min.js') }}"></script>
 <script src="{{ asset('plugin/datatable/Buttons-2.3.3/js/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('plugin/datatable/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
 <script src="{{ asset('plugin/datatable/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
 <script src="{{ asset('plugin/datatable/Buttons-2.3.3/js/buttons.html52.min.js') }}"></script>
 <script src="{{ asset('plugin/datatable/Buttons-2.3.3/js/buttons.print2.min.js') }}"></script>
@endpush

