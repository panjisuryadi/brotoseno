   <style type="text/css">
    .table thead th .supplier{
          color: green;
        }
   </style>

   <div class="flex justify-between py-1 border-bottom">
                        <div>
                          <h1 class="font-semibold"> @lang('Purchases Supplier')</h1>
                        </div>
                        <div id="buttons_supplier">
                        </div>
                    </div>
<div class="table-responsive mt-1">
    <table id="datatable_supplier" style="width: 100%;z-index: 2 !important;" class="table table-bordered table-hover table-responsive-sm">
        <thead>
            <tr>
                <th style="width: 2%!important;">No</th>
                <th style="width: 3%!important;" class="text-center">{{ Label_case('reference') }}</th>
                <th class="supplier text-center">{{ __('Supplier') }}</th>
                <th style="width: 4%!important;" class="text-center">{{ __('Status') }}</th>
                <th style="width: 8%!important;" class="text-center">{{ __('Total Amount') }}</th>

                  <th style="width: 8%!important;" class="text-center">
                    {{ Label_case('paid_amount') }}
                </th>
                 <th style="width: 7%!important;" class="text-sm text-center">
                    {{ Label_case('payment_status') }}
                </th>
                <th style="width: 7%!important;" class="text-center">
                    {{ __('Action') }}
                </th>
            </tr>
        </thead>
    </table>
</div>





@push('page_scripts')
<x-library.datatable />
   <script type="text/javascript">
        $('#datatable_supplier').DataTable({
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
            ajax: '{{ route("$module_name.index_data_type",'supplier') }}',
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

                {data: 'reference', name: 'reference'},
                {data: 'buyer', name: 'buyer'},
                {data: 'status', name: 'status'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'paid_amount', name: 'paid_amount'},
                {data: 'payment_status', name: 'payment_status'},

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
        .appendTo("#buttons_supplier");



    </script>


@endpush