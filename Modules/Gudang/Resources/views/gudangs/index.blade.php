@extends('layouts.app')
@section('title', $module_title)
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
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{ $module_name }}CreateModal">
                            {{ __('Add') }} {{ $module_title }} <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">No</th>
                                    <th style="width: 18%!important;" class="text-left">{{ __('Code') }}</th>
                                    <th class="text-left">{{ __('Name') }}</th>
                                    <th style="width: 15%!important;" class="text-center">
                                         {{ __('Updated') }}
                                    </th>
                                    <th style="width: 18%!important;" class="text-center">
                                        {{ __('Action') }}
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
<!-- batass================================Create Modal============================= -->
<div class="modal fade" id="{{ $module_name }}CreateModal" tabindex="-1" role="dialog" aria-labelledby="{{ $module_name }}CreateModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $module_name }}CreateModalLabel font-semibold">
<i class="bi bi-grid-fill"></i> &nbsp;
                {{ __('Add') }} {{ $module_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormTambah" action="{{ route("$module_name.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
              <div id='ResponseInput' style="font-size: 16px;color: green;"></div>
                  <div class="flex flex-row grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'code';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="{{ $field_name }}"
                         placeholder="{{ $field_placeholder }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>
                 <div class="form-group">
                                <?php
                                $field_name = 'name';
                                $field_lable = label_case($field_name);
                                $field_placeholder =$field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                <input class="form-control" placeholder="{{ $field_placeholder }}" type="text" name="{{ $field_name }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>
                        </div>
                    </div>
                <div id="ModalFooter" class="modal-footer"> </div>
            </form>
        </div>
    </div>
</div>
{{-- end modal ======================================================================--}}
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
            ajax: '{{ route("$module_name.index_data") }}',
            dom: 'Blfrtip',
            buttons: [
                // 'copy',
                // 'csv',
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
                }, {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
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


<script>
jQuery.noConflict();
(function( $ ) {

 function autoRefresh(){
      var table = $('#datatable').DataTable();
        table.ajax.reload();

}
    function Tambah()
    {
        $.ajax({
            url: $('#FormTambah').attr('action'),
            type: "POST",
            cache: false,
            data: $('#FormTambah').serialize(),
            dataType:'json',

            success: function(data) {
                  console.log(data.error)
                    if($.isEmptyObject(data.error)){
                      $('#ResponseInput').html(data.success);
                      $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('fast');
                      setTimeout(function(){ autoRefresh(); }, 1000);
                      $('#FormTambah').each(function(){
                        this.reset();
                    });


                    }else{
                        printErrorMsg(data.error);
                    }
                }
        });
    }




 function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {
            console.log(key);
             $('#'+key+'').addClass("");
             $('#'+key+'').addClass("is-invalid");
              $('.'+key+'_err').text(value);

            });
        }

$(document).ready(function(){

    var Tombol = "<button type='button' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
    Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanTambah'>{{ __('Create') }}</button>";
    $('#ModalFooter').html(Tombol);

    $("#FormTambah").find('input[type=text],textarea,select').filter(':visible:first').focus();

    $('#SimpanTambah').click(function(e){
        e.preventDefault();
        Tambah();
    });

    $('#FormTambah').submit(function(e){
        e.preventDefault();
        Tambah();
    });
});
})(jQuery);
</script>





@endpush