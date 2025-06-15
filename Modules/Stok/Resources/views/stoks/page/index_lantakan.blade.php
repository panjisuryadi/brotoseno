@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}} {{$module_action}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                     <div>
                       <p class="uppercase text-lg text-gray-600 font-semibold">
                      Stok <span class="text-green-500 uppercase">{{$module_action}}</span></p>
                        </div>
                        <div id="buttons">
                              <a href="{{ route('stok.export_excel', ['status' =>'lantakan']) }}"  
                                 target="_blank" 
                                 class="btn btn-success px-3">
                                 <i class="bi bi-file-excel"></i>
                                     @lang('Export Lantakan')
                                </a>
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="lantakan" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                <th style="width: 6%!important;">No</th>
                           <th class="text-center">{{ Label_Case('Karat') }}</th>
                               
                          <th class="text-center">{{ Label_Case('Berat') }}</th>
                          <th class="text-center" style="width: 20%!important;">{{ Label_Case('Aksi') }}</th>
                           
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @include('produksi::produksis.partial.index')

        </div>
    </div>
</div>
@endsection

{{-- <x-library.datatable /> --}}
@push('page_scripts')
   <script type="text/javascript">
        $('#lantakan').DataTable({
           processing: true,
           serverSide: true,
           autoWidth: true,
           responsive: true,
           lengthChange: true,
            searching: true,
           "oLanguage": {
            "sSearch": "<i class='bi bi-search'></i> {{ __("labels.table.search") }} : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per {{ __("labels.table.page") }} ",
            "sInfo": "{{ __("labels.table.showing") }} _START_ s/d _END_ {{ __("labels.table.from") }} <b>_TOTAL_ data</b>",
            "sInfoFiltered": "(filter {{ __("labels.table.from") }} _MAX_ total data)",
            "sZeroRecords": "{{ __("labels.table.not_found") }}",
            "sEmptyTable": "{{ __("labels.table.empty") }}",
            "sLoadingRecords": "Harap Tunggu...",
            "oPaginate": {
                "sPrevious": "{{ __("labels.table.prev") }}",
                "sNext": "{{ __("labels.table.next") }}"
            }
            },
            "aaSorting": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.index_data_lantakan") }}',
            
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {data: 'karat', name: 'karat'},
                {data: 'weight', name: 'weight'},
             
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });



    </script>

<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {

   // $("#buttons").toggle('hide');

    $(document).on('click', '#Tambah, #Edit', function(e){
        e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush