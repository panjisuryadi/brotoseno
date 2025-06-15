<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="text-lg font-bold uppercase">Penerimaan Barang Buy Back & Barang Luar (Toko)</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="endDate">End Date</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-1">
                    <table id="buyback-barangluar-nota-datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="width: 5%!important;">No</th>
                                <th style="width: 12%!important;">Tanggal</th>
                                <th style="width: 18%!important;">Nota</th>
                                <th style="width: 12%!important;">Cabang</th>
                                <th style="width: 14%!important;">Grand Total</th>
                                <th style="width: 10%!important;">Status</th>
                                <th style="width: 12%!important;">Jumlah Barang</th>

                                <th style="width: 15%!important;" class="@if(auth()->user()->can('edit_buybacktoko') || auth()->user()->can('show_buybacktoko') || auth()->user()->can('delete_buybacktoko'))
                               @else
                               no-sort
                                @endif
                                    text-center">
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
<x-library.datatable />

@push('page_scripts')
<script type="text/javascript">

        let startDate = '';
        let endDate = '';

        $('#startDate, #endDate').on('change', function() {
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            $('#buyback-barangluar-nota-datatable').DataTable().ajax.reload();
        });

        $('#buyback-barangluar-nota-datatable').DataTable({
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
                    "visible": false,
                }
            ],

            "sPaginationType": "simple_numbers",
            ajax: {
                url: '{{ route("$module_name.toko.buyback-barangluar.index_data_nota_office") }}',
                data: function(d) {
                    d.startDate = startDate;
                    d.endDate = endDate;
                }
            },
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

                {data: 'date', name: 'date'},
                {data: 'nota', name:  'nota'},
                {data: 'cabang', name:  'cabang'},
                {data: 'nominal', name:  'nominal'},

                {data: 'status', name: 'status'},
                {data: 'total_item', name: 'total_item'},


                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })
        .buttons().remove()
        .container()



    </script>
@endpush
