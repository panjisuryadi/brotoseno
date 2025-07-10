@extends('layouts.app')
@section('title', 'Buyback')
@section('third_party_stylesheets')
    <style>
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-table td {
            background-color: #fff;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $module_title }}</li>
    </ol>
@endsection
@section('content')
    <div class="container-fluid">

        @can('show_total_stats')
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                                <i class="bi bi-cash font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-primary">{{ $formattedTotalPrice }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('BuyBack Purchases')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                                <i class="bi bi-speedometer2 font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-warning">{{ $formattedTotalWeight }}</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('BuyBack Weight')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                                <i class="bi bi-arrow-return-right font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-success">{{ $totalQuantity }} Pcs</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('BuyBack Quantity')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0 d-flex align-items-center shadow-sm">
                            <div class="bg-gradient-info p-4 mfe-3 rounded-left">
                                <i class="bi bi-people font-2xl"></i>
                            </div>
                            <div>
                                <div class="text-value text-info">{{ $totalCustomers }} Orang</div>
                                <div class="text-muted text-uppercase font-weight-bold small">
                                    @lang('Total Customer')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex justify-between py-1 border-bottom">
                            <div>

                                <div class="btn-group">
                                    <a href="#" class="px-3 btn btn-danger" data-toggle="modal"
                                        data-target="#createModal">
                                        + BuyBack <i class="bi bi-plus"></i>
                                    </a>
                                </div>

                            </div>
                            <div id="buttons"></div>
                        </div>

                        {{-- FILTER TANGGAL --}}
                        <form id="filterForm" class="form-inline mb-2" style="float: right;">
                            <input type="date" name="startDate" id="startDate" class="form-control form-control-sm mx-1"
                                placeholder="Dari" value="{{ request('startDate') }}">

                            <input type="date" name="endDate" id="endDate" class="form-control form-control-sm mx-1"
                                placeholder="Sampai" value="{{ request('endDate') }}">

                            <button type="submit" class="btn btn-sm mx-1 btn-primary">Filter</button>
                        </form>

                        <div class="table-responsive mt-1">
                            <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 5%!important;" class="text-center">
                                            NO
                                        </th>
                                        <th style="width: 20%!important;" class="text-center">
                                            Product Code
                                        </th>
                                        <th style="width: 13%!important;" class="text-center">
                                            Nota
                                        </th>
                                        <th style="width: 20%!important;" class="text-center">
                                            Kondisi
                                        </th>
                                        <th style="width: 10%!important;" class="text-center">
                                            Harga
                                        </th>
                                        <th style="width: 10%!important;" class="text-center">
                                            Potongan
                                        </th>
                                        <th style="width: 10%!important;" class="text-center">
                                            Tambahan
                                        </th>
                                        <th style="width: 15%!important;" class="text-center">
                                            Tanggal
                                        </th>
                                        <th style="width: 7%!important;" class="text-center">
                                            #
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

    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-lg font-bold" id="addModalLabel">Buyback +</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="/buyback_insert" target="_blank" method="post">
                        @csrf
                        {{-- <div class="form-group">
                            <label for="">Code Product</label>
                            <input type="text" class="form-control" name="product" required>
                        </div> --}}
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">No Nota</label>
                                    <input type="hidden" name="product" id="product">
                                    <input type="text" class="form-control" name="nota" id="nota"
                                        onkeyup="view_nota();" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Kondisi</label>
                                    <input type="text" class="form-control" name="kondisi" id="kondisi" required
                                        readonly>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label for="" id="label_potongan">Max Harga Potongan : </label>
                                    <input type="number" class="form-control" potongan="{{ $potongan }}"
                                        name="potongan" id="potongan" onkeyup="change_harga();" required
                                        value="0">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label for="" id="label_tambahan">Max Harga Tambahan : </label>
                                    <input type="number" class="form-control" tambahan="{{ $tambahan }}"
                                        name="tambahan" id="tambahan" onkeyup="change_harga();" required
                                        value="0">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Harga : </label>
                                    <input type="hidden" name="harga_awal" id="harga_awal">
                                    <input type="hidden" name="harga" id="harga">
                                    <input type="text" class="form-control" name="harga_label" id="harga_label"
                                        value="0" readonly>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Payment</label>
                                    <select name="payment" id="payment" class="form-control">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <table class="invoice-table" id="invoice-table" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Img</th>
                                            <th>Kode</th>
                                            <th>Jenis</th>
                                            <th>Deskripsi</th>
                                            <th>Berat</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img id="t_image" src="./storage/uploads/1742774180.png" order="0"
                                                    width="70" class="img-thumbnail"></td>
                                            <td id="t_kode">Emas Dummy</td>
                                            <td id="t_jenis">Emas Antam</td>
                                            <td id="t_desc">Gold 1 ml Ruth</td>
                                            <td id="t_berat">1 g</td>
                                            <td id="t_harga">Rp. 9.999.999</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-sm btn-success" id="btn_submit" onclick="return confirmAndReload();"
                            style="display: none;">Submit</button>
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
                    "sSearch": "<i class='bi bi-search'></i> {{ __('labels.table.search') }} : ",
                    "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per {{ __('labels.table.page') }} ",
                    "sInfo": "{{ __('labels.table.showing') }} _START_ s/d _END_ {{ __('labels.table.from') }} <b>_TOTAL_ data</b>",
                    "sInfoFiltered": "(filter {{ __('labels.table.from') }} _MAX_ total data)",
                    "sZeroRecords": "{{ __('labels.table.not_found') }}",
                    "sEmptyTable": "{{ __('labels.table.empty') }}",
                    "sLoadingRecords": "Harap Tunggu...",
                    "oPaginate": {
                        "sPrevious": "{{ __('labels.table.prev') }}",
                        "sNext": "{{ __('labels.table.next') }}"
                    }
                },
                "aaSorting": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
                "sPaginationType": "simple_numbers",
                ajax: {
                    url: '{{ route('buyback.index_data') }}',
                    data: function(d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                        console.log(d);
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

                    {
                        data: 'product_code',
                        name: 'product_code'
                    },
                    {
                        data: 'nota',
                        name: 'nota'
                    },
                    {
                        data: 'kondisi',
                        name: 'kondisi'
                    }, {
                        data: 'harga',
                        name: 'harga'
                    },
                    // {
                    //     data: 'ph',
                    //     name: 'ph'
                    // }
                    // ,
                    {
                        data: 'potongan',
                        name: 'potongan'
                    },
                    {
                        data: 'tambahan',
                        name: 'tambahan'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ]
            })
            .buttons()
            .container()
            .appendTo("#buttons");

        $('#startDate, #endDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
        console.log('script loaded');

        $(document).ready(function() {
            $('#startDate').val('');
            $('#endDate').val('');
            table.ajax.reload();
        });

        // Event onsubmit
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            const start = $('#startDate').val();
            const end = $('#endDate').val();

            if (start && end && start > end) {
                alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
                return;
            }

            table.ajax.reload();
        });
    </script>

    <script type="text/javascript">
        jQuery.noConflict();
    </script>
    <script src="./js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function confirmAndReload() {
            if (confirm('Lanjutkan Buyback ?')) {
                // Reload after 5 seconds (5000 ms)
                setTimeout(() => {
                    location.reload();
                }, 5000);

                return true; // continue with form submit or action
            }

            return false; // cancel action if user pressed Cancel
        }

        function change_harga() {
            let awal = $("#harga_awal").val();
            let potongan = $("#potongan");
            let tambahan = $("#tambahan");
            let tambahanPercent = parseFloat($('#tambahan').attr('tambahan')) || 0;
            let maxTambahan = awal * tambahanPercent / 100;
            let potonganPercent = parseFloat($('#potongan').attr('potongan')) || 0;
            let maxPotongan = awal * potonganPercent / 100;

            console.log(awal);
            console.log(maxTambahan);
            console.log(maxPotongan);
            let harga = parseInt(awal);
            let label = 0;
            if (potongan.val() > maxPotongan) {
                potongan.val(maxPotongan);
            }
            if (tambahan.val() > maxTambahan) {
                tambahan.val(maxTambahan);
            }
            if (potongan.val() == 0) {
                tambahan.prop('disabled', false);
                tambahan.prop('readonly', false);
            } else {
                tambahan.val(0);
                harga = awal - potongan.val();
                tambahan.prop('disabled', true);
                tambahan.prop('readonly', true);
            }

            if (tambahan.val() == 0) {
                potongan.prop('disabled', false);
                potongan.prop('readonly', false);
            } else {
                potongan.val(0);
                harga = parseInt(harga) + parseInt(tambahan.val());
                potongan.prop('disabled', true);
                potongan.prop('readonly', true);
            }

            let rupiah = 'Rp ' + harga.toLocaleString('id-ID');
            $("#harga").val(harga);
            $("#harga_label").val(rupiah);
        }

        function view_nota() {
            $("#btn_submit").hide();
            $('#invoice-table').hide();

            let nota = $('#nota').val();
            let length = nota.length;
            $('#potongan').val(0);
            $('#tambahan').val(0);
            $('#kondisi').prop('readonly', true);

            if (length > 9) {
                $('#t_image').html();
                $('#t_kode').html();
                $('#t_jenis').html();
                $('#t_desc').html();
                $('#t_berat').html();
                $('#t_harga').html();
                $.ajax({
                    url: '/buyback_nota/' + nota, // The URL for your route
                    type: 'GET', // Request method
                    dataType: 'json', // Expecting JSON response
                    success: function(response) {
                        // On success, handle the response
                        if (response) {
                            if (response.harga !== '') {
                                let price = parseInt(response.price);
                                let rupiah = 'Rp ' + price.toLocaleString('id-ID');
                                let tambahanPercent = parseFloat($('#tambahan').attr('tambahan')) || 0;
                                let maxTambahan = price * tambahanPercent / 100;
                                let potonganPercent = parseFloat($('#potongan').attr('potongan')) || 0;
                                let maxPotongan = price * potonganPercent / 100;
                                let rupiahMaxPotongan = 'Rp ' + maxPotongan.toLocaleString('id-ID');
                                let rupiahMaxTambahan = 'Rp ' + maxTambahan.toLocaleString('id-ID');

                                $('#potongan').attr('max', maxPotongan);
                                $('#label_potongan').html('Potongan Max ' + potonganPercent + '% : ' +
                                    rupiahMaxPotongan);
                                $('#tambahan').attr('max', maxTambahan);
                                $('#label_tambahan').html('Tambahan Max ' + tambahanPercent + '% : ' +
                                    rupiahMaxTambahan);

                                $('#kondisi').prop('readonly', false);

                                $('#product').val(response.product);

                                $('#harga').val(price);
                                $('#t_image').attr('src', '/storage/uploads/' + response.image);
                                $('#t_kode').html(response.kode);
                                $('#t_jenis').html(response.jenis);
                                $('#t_desc').html(response.desc);
                                $('#t_berat').html(response.berat);
                                $('#t_harga').html(rupiah);
                                $('#harga_label').val(rupiah);
                                $('#harga_awal').val(price);
                                $('#btn_submit').show();
                                $('#invoice-table').show();
                            } else {
                                alert('Nota not valid');
                            }
                        } else {
                            // $("#result").html("<p>No data found.</p>");
                        }
                    },
                    error: function() {
                        // Handle errors
                        alert('An error occurred.');
                    }
                });
            }
        }
    </script>
@endpush
