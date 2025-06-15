   <div class="flex justify-between py-1 border-bottom">
                        <div>
                          <h1 class="font-semibold"> @lang('Purchases History')</h1>
                        </div>
                        <div id="buttons_history">
                        </div>
                    </div>
<div class="table-responsive mt-1">
    <table id="datatable_history" style="width: 100%;z-index: 2 !important;" class="table table-bordered table-hover table-responsive-sm">
        <thead>
            <tr>
                <th style="width: 6%!important;">No</th>
                <th style="width: 9%!important;" class="text-center">{{ Label_case('reference') }}</th>
                <th style="width: 23%!important;" class="text-center">{{ __('Produk') }}</th>
                <th style="width: 8%!important;" class="text-center">{{ __('Qty') }}</th>
                <th style="width: 13%!important;" class="text-center">{{ __('Admin') }}</th>

                  <th style="width: 15%!important;" class="text-center">
                    {{ Label_case('Date') }}
                </th>

                <th style="width: 11%!important;" class="text-center">
                    {{ __('Action') }}
                </th>
            </tr>
        </thead>
    </table>
</div>





@push('page_scripts')
<x-library.datatable />
   <script type="text/javascript">
        $('#datatable_history').DataTable({
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
            ajax: '{{ route("$module_name.history") }}',
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
                {data: 'produk', name: 'produk'},
                {data: 'qty', name: 'qty'},
                {data: 'username', name: 'username'},
                {data: 'updated_at', name: 'updated_at'},


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
        .appendTo("#buttons_history");



    </script>


@endpush