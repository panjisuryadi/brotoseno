@extends('layouts.app')
@section('title', 'Karat')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}}</li>
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

                <div class="btn-group">
                    <a  href="{{ route('karat.create') }}" class="px-3 btn btn-warning">
                        Tambah Karat <i class="bi bi-plus"></i>
                    </a>
                    <a href="{{ route('karats.history') }}" class="px-3 btn btn-success">
                        History Harga <i class="bi bi-plus"></i>
                    </a>
                    @if(empty($harga->harga))
                        <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#createModal">
                            Set Harga <i class="bi bi-plus"></i>
                        </a>
                    @else
                        <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#createModal">
                            Set Harga <i class="bi bi-plus"></i>
                        </a>
                        
                        
                        <div class="text-center ml-5">
                            <div class="fw-bold h3 text-danger" style="text-decoration: underline;">
                                IDR {{ number_format($harga->harga) }}
                            </div>
                            <div>
                                Updated at : {{ $harga->updated_at }}
                            </div>
                        </div>
    
                    @endif
                </div>

                    </div>
                        <div id="buttons"></div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 7%!important;">
                                        NO
                                    </th>
                                    <th>
                                        Karat
                                    </th>
                                     <th style="width: 13%!important;" class="text-center">
                                        Tipe
                                    </th>  

                                     <th style="width: 9%!important;" class="text-center">
                                        Coef
                                    </th>  
                                     <!-- <th style="width: 7%!important;" class="text-center">
                                        Ph
                                    </th>  -->
                                    <th style="width: 8%!important;" class="text-center">
                                        Harga
                                    </th> 
                                    <th style="width: 8%!important;" class="text-center">
                                        Margin
                                    </th> 
                                    <th style="width: 8%!important;" class="text-center">
                                        Harga Jual
                                    </th> 

                                    <th style="width: 10%!important;" class="text-center">
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

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Set Harga</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/karats" method="post">
                    @csrf
                    <label for="">Harga</label>
                    <input type="number" class="form-control" name="harga">
                    <br>
                    <button class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Set Harga</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/karats_update" method="post">
                    @csrf
                    <label for="">Harga</label>
                    <input type="number" class="form-control" name="harga">
                    <button class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
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
            ajax: '{{ route("karats.index_data") }}',
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
                    data: 'karat',
                    name: 'karat'
                },{
                    data: 'type',
                    name: 'type'
                },{
                    data: 'coef',
                    name: 'coef'
                },
                // {
                //     data: 'ph',
                //     name: 'ph'
                // }
                // ,
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'margin',
                    name: 'margin'
                },
                {
                    data: 'rekomendasi',
                    name: 'rekomendasi'
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
