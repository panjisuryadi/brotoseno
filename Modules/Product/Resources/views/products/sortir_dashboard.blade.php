@php
 $module_title = 'Sortir';
@endphp
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style type="text/css">
div.dataTables_wrapper div.dataTables_filter input {
margin-left: 0.5em;
display: inline-block;
width: 220px !important;
}
div.dataTables_wrapper div.dataTables_length select {
width: 70px !important;
display: inline-block;
}
</style>


<div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-lg">23</div>
                        <div>Total Stok Opname</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-lg" id="totalcategory">0</div>
                        <div>Total Stok Opname</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-md-4">
                <a class="card" href="javascript:;" id="successadjustment">
                    <div class="card-body text-dark">
                        <div class="text-value-lg" id="totalaset">0</div>
                        <div>Total Sortir</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a class="card" href="javascript:;" id="pendingadjustment">
                    <div class="card-body">
                        <div class="text-value-lg" id="totalproduct">0</div>
                        <div>Total Approve</div>
                        <div class="progress progress-xs my-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>















  <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">

                    <div class="card">
                <div class="card-body">
                    <div class="flex justify-between pb-3 border-bottom">
                        <div class="font-semibold text-lg">
                          <i class="bi bi-plus"></i>  Sortir Products
                            </div>

                        <div id="buttons"></div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">NO</th>
                                    <th style="width: 9%!important;">{{ Label_case('image') }}</th>
                                    <th>{{ Label_case('product_name') }}</th>
                                    <th>{{ Label_case('price') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_case('Status') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_case('Lokasi /Kondisi') }}</th>
                                    <th style="width: 21%!important;" class="text-center">
                                        Action
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
        ajax: '{{ route("products.ajax_sortir") }}',
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
            data: 'product_image',
            name: 'product_image'
        }, {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'product_price',
            name: 'product_price'
        }, {
            data: 'status',
            name: 'status'
        }, {
            data: 'lokasi',
            name: 'lokasi'
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
$(document).on('click', '#Tambah, #Edit, #Approve, #Sortir', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }

        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-md');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }

        if($(this).attr('id') == 'Approve')
        {
            $('.modal-dialog').addClass('modal-md');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-xl');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Approve {{ Label_case($module_title) }}');
        }

       if($(this).attr('id') == 'Sortir')
        {
            $('.modal-dialog').addClass('modal-md');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-xl');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Sortir {{ Label_case($module_title) }}');
        }

        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
        $('#rfid').focus();
    });


})(jQuery);
</script>


@endpush