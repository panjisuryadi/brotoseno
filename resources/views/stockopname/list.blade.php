@extends('layouts.app')
@section('title', 'Stock Opname')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Stock Opname</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <a href="./stockopname/done/{{$stockopname->id}}" class="btn btn-success {{$button}}">Done</a>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">
                                        NO
                                    </th>
                                    <th style="width: 15%!important;" class="text-center">
                                        Code
                                    </th>
                                    <th style="width: 15%!important;" class="text-center">
                                        Posisi
                                    </th>
                                     <th style="width: 15%!important;" class="text-center">
                                        Name
                                    </th>  

                                     <th style="width: 10%!important;" class="text-center">
                                        Capacity
                                    </th>  
                                    <th style="width: 10%!important;" class="text-center">
                                        Used
                                    </th>  
                                    <th style="width: 10%!important;" class="text-center">
                                        Status
                                    </th>  
                                    <th style="width: 20%!important;" class="text-center">
                                       {{__('Action')}}
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const disabledLink = document.querySelector('.btn.disabled'); // Select based on both classes

        if (disabledLink) {
            disabledLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevents navigation
            });
        }
    });
        $('#datatable').DataTable({
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
            ajax: '{{ route("stock_opname.index_data",["id" => $stockopname->id]) }}',
            dom: 'Blfrtip',
            buttons: [
                'excel',
                'pdf',
                'print'
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'posisi',
                    name: 'posisi'
                },
                {
                    data: 'name',
                    name: 'name'
                },{
                    data: 'capacity',
                    name: 'capacity'
                },{
                    data: 'used',
                    name: 'used'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })
        .buttons()
        .container()
        .appendTo("#buttons");
    </script>

    <script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
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
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush
