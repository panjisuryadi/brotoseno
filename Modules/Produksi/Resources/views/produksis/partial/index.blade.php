
<div class="card">
    <div class="card-body">
        <div class="flex justify-between py-1 border-bottom">
            <div>
           <p class="uppercase text-lg text-gray-600 font-semibold mb-3">
            Stok <span class="text-yellow-500 uppercase">Bahan</span></p>
            </div>
             
    
            <div id="excelButton">
             <a href="{{ route('produksi.proses') }}"
                    class="btn btn-primary px-3">
                    <i class="bi bi-plus"></i>@lang('Proses')&nbsp;
                </a>
            </div>
             

            
           
        </div>
        <div class="table-responsive mt-1">
            <table id="datatableProduksi" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th style="">No</th>
                        <th style="width: 15%!important;" class="text-center">{{ __('Kode Produksi') }}</th>
                        <th class="text-left">{{ __('Asal') }}</th>
                        <th class="text-left">{{ __('Hasil') }}</th>
                        {{-- <th style="width: 18%!important;" class="text-center">
                            {{ __('Action') }}
                        </th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
{{-- Modal --}}

<x-library.datatable />
@push('page_scripts')
    <script type="text/javascript">
        $('#datatableProduksi').DataTable({
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
            ajax: '{{ route("produksi.index_data") }}',
            dom: 'Blfrtip',
            buttons: [
                'excel',
                'print'
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {data: 'code', name: 'Kode Produksi'},
                {data: 'asal', name: 'Asal'},
                {data: 'hasil', name: 'Hasil'},
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false
                // }
            ]
        })
        .buttons()
        .container()
        .appendTo("#excelButton");
    </script>

@endpush