@extends('layouts.app')

@section('title', 'Baki')

@section('third_party_stylesheets')

@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Baki</li>
    </ol>
@endsection

@push('page_css')
<style type="text/css">
 
.c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 0.3rem;
}

</style>
@endpush

@section('content')
<div class="container-fluid">
<div class="card">
    <div class="card-body">
        <div class="row">

            <!-- Left Side: Product List -->
            <div class="col-md-6">
                <h1><strong>Origin</strong></h1>
                <br>
                <table id="datatable" style="width: 100%" class="mt-5 table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th style="width: 5%!important;">No</th>
                            <th style="width: 16%!important;">Code</th>
                            <th style="width: 17%!important;">{{ Label_case('product') }}</th>
                            <th style="width: 10%!important;" class="text-center">Baki</th>
                            <th style="width: 6%!important;" class="text-center">Berat</th>
                            <th style="width: 16%!important;" class="text-center">{{ Label_case('Harga') }}</th>
                            <!-- <th style="width: 25%!important;" class="text-center">{{ Label_case('Date') }}</th> -->
                            <th style="width: 5%!important;" class="text-center">#</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="col-md-6">
                <h1><strong>Destination | {{$baki->name}} | {{$baki->posisi}}</strong></h1>
                <br>
                <table id="datatable2" style="width: 100%" class="mt-5 table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th style="width: 5%!important;">No</th>
                            <th style="width: 16%!important;">Code</th>
                            <th style="width: 17%!important;">{{ Label_case('product') }}</th>
                            <th style="width: 10%!important;" class="text-center">Baki</th>
                            <th style="width: 6%!important;" class="text-center">Berat</th>
                            <th style="width: 16%!important;" class="text-center">{{ Label_case('Harga') }}</th>
                            <!-- <th style="width: 25%!important;" class="text-center">{{ Label_case('Date') }}</th> -->
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

</div>

<div class="modal fade" id="confirmProductModal" tabindex="-1" aria-labelledby="customProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customProductModalLabel">Summary</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="mt-3" id="copy">

        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-bold fs-5">Total:</span>
            <span id="total" class="fw-bold fs-4 text-success">Rp 0</span>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" form="" class="btn btn-primary" onclick="submit_form();">submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Custom Product Modal -->
<div class="modal fade" id="customProductModal" tabindex="-1" aria-labelledby="customProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customProductModalLabel">Add Custom Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="custom-product-form">
          <div class="mb-3">
            <label class="form-label">Service</label>
            <input type="text" class="form-control" id="service" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Desc</label>
            <input type="text" class="form-control" id="desc" required>
            <!-- <textarea name="form-control" id="desc" name="desc" required>hello</textarea> -->
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" onkeyup="sum_harga();" required>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="custom-product-form" class="btn btn-primary">Add Product</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('page_scripts')
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
<!-- Bootstrap JS (with Popper) – CDN version -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AHR5oKn06PWzGk+E9Y1kCfmhktbZ5d9+8wCjUY8H7Sk/9kccB+ApPBALSczF+" crossorigin="anonymous"></script> -->
    <script> 
    function submit_form(){
        let cust = $("#customer_modal").val();
        $("#customer").val(cust);
        $("#sale").submit();
        // return true;
    }

    function copy_div(){
        let div = $("#preview-area").html();
        let total = $("#total-nominal").html();
        $("#copy").html(div);
        $("#total").html(total);
        $('#copy input[name="harga[]"]').remove();
        $('#copy .btn-delete-current').remove();
    }     
    $('#datatable2').DataTable({
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
        ajax: '/sale/index_data/{{$id}}',
        dom: 'lfrtip',
        // dom: 'Blfrtip',
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
        }, 
        // {
        //     data: 'product_code',
        //     name: 'product_code'
        // }, 
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'baki',
            name: 'baki'
        }, 
        {
            data: 'berat_emas',
            name: 'berat_emas'
        }, 
        {
            data: 'rekomendasi',
            name: 'rekomendasi'
        }, 
        // {
        //     data: 'created_at',
        //     name: 'created_at'
        // },
        // {
        //     data: null,
        //     className: 'text-center',
        //     render: function(data, type, row, meta) {
        //         return `<button class="btn btn-sm btn-success btn-add-to-preview" data-row='${JSON.stringify(row)}'>Add</button>`;
        //     }
        // },

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
    .appendTo("#buttons"); 

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
        ajax: '/sale/index_data_baki/{{$id}}',
        dom: 'lfrtip',
        // dom: 'Blfrtip',
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
        }, 
        // {
        //     data: 'product_code',
        //     name: 'product_code'
        // }, 
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'baki',
            name: 'baki'
        }, 
        {
            data: 'berat_emas',
            name: 'berat_emas'
        }, 
        {
            data: 'rekomendasi',
            name: 'rekomendasi'
        }, 
        // {
        //     data: 'created_at',
        //     name: 'created_at'
        // },
        // <button class="btn btn-sm btn-success btn-add-to-preview" data-row="{&quot;id&quot;:508,&quot;category_id&quot;:15,&quot;cabang_id&quot;:null,&quot;product_name&quot;:&quot;<div class=\&quot;flex items-center gap-x-2\&quot;>\n                        <div>\n                           <div class=\&quot;text-xs font-normal text-yellow-600 dark:text-gray-400\&quot;>\n                            CINCIN</div>\n\n                            <h3 class=\&quot;small font-medium text-gray-600 dark:text-white \&quot;> CIncin new</h3>\n                             <div class=\&quot;text-xs font-normal text-blue-500 font-semibold\&quot;>\n                            </div>\n\n\n                        </div>\n                    </div>&quot;,&quot;product_code&quot;:&quot;CEMAS 375200125793&quot;,&quot;product_barcode_symbology&quot;:&quot;C128&quot;,&quot;rfid&quot;:null,&quot;barcode_rfid&quot;:null,&quot;product_unit&quot;:&quot;Gram&quot;,&quot;product_stock_alert&quot;:5,&quot;product_order_tax&quot;:null,&quot;product_note&quot;:null,&quot;status&quot;:&quot;<div class=\&quot;flex row justify-center items-center px-3\&quot;>\n\n<button class=\&quot;btn btn-info px  btn-sm p-1 text-xs\&quot;>In Progress</button>\n\n</div>\n&quot;,&quot;images&quot;:&quot;1742774180.png&quot;,&quot;created_at&quot;:&quot;<div class=\&quot;text-center\&quot;><span class=\&quot;text-gray-500\&quot;>20/01/2025</span> | <span class=\&quot;ml-1 text-jsr\&quot;>16:16</span></div>&quot;,&quot;updated_at&quot;:&quot;2025-04-27T18:10:24.000000Z&quot;,&quot;dist_toko_item_id&quot;:null,&quot;diamond_certificate_id&quot;:null,&quot;karat_id&quot;:33,&quot;berat_emas&quot;:1.9,&quot;total_karatberlians&quot;:null,&quot;product_price&quot;:0,&quot;status_id&quot;:1,&quot;group_id&quot;:4,&quot;model_id&quot;:11,&quot;produksi_item_id&quot;:null,&quot;deleted_at&quot;:null,&quot;goodreceipt_item_id&quot;:null,&quot;is_nota&quot;:1,&quot;baki_id&quot;:3,&quot;harga&quot;:&quot;1500000.00&quot;,&quot;media&quot;:[],&quot;karat&quot;:&quot;EMAS 375&quot;,&quot;category&quot;:{&quot;id&quot;:15,&quot;kategori_produk_id&quot;:1,&quot;category_code&quot;:&quot;CCN&quot;,&quot;category_name&quot;:&quot;CINCIN&quot;,&quot;slug&quot;:&quot;cincin&quot;,&quot;image&quot;:&quot;no_foto.png&quot;,&quot;parent_id&quot;:null,&quot;created_at&quot;:&quot;2025-01-16T09:41:06.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-01-16T09:42:41.000000Z&quot;},&quot;product_item&quot;:{&quot;id&quot;:2,&quot;product_id&quot;:508,&quot;karat_id&quot;:null,&quot;certificate_id&quot;:null,&quot;shape_id&quot;:null,&quot;supplier_id&quot;:null,&quot;customer_id&quot;:null,&quot;etalase_id&quot;:null,&quot;baki_id&quot;:null,&quot;location_id&quot;:null,&quot;jenis_perhiasan_id&quot;:null,&quot;parameter_berlian_id&quot;:null,&quot;gold_kategori_id&quot;:null,&quot;karat_berlian_id&quot;:null,&quot;clarity_id&quot;:null,&quot;product_sale&quot;:null,&quot;gudang&quot;:null,&quot;berat_total&quot;:1.9020000000000001,&quot;berat_emas&quot;:0,&quot;berat_accessories&quot;:0.001,&quot;tag_label&quot;:0,&quot;berat_label&quot;:0.001,&quot;brankas&quot;:null,&quot;jenis_mutiara_id&quot;:null,&quot;produk_model_id&quot;:null,&quot;cabang_id&quot;:null,&quot;margin&quot;:null,&quot;created_at&quot;:&quot;2025-01-20T09:16:16.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-01-20T09:16:16.000000Z&quot;,&quot;diamond_certificate_id&quot;:null,&quot;gia_report_number&quot;:null,&quot;karatberlians&quot;:null,&quot;shapeberlians_id&quot;:null,&quot;qty&quot;:null,&quot;jenis_sertifikat&quot;:null,&quot;goodsreceipt_item_id&quot;:null,&quot;additional_data&quot;:null,&quot;no_series&quot;:null,&quot;no_certificate&quot;:null},&quot;karats&quot;:{&quot;id&quot;:33,&quot;parent_id&quot;:null,&quot;name&quot;:&quot;EMAS 375&quot;,&quot;description&quot;:null,&quot;kode&quot;:&quot;375&quot;,&quot;type&quot;:&quot;GOLD&quot;,&quot;harga&quot;:null,&quot;coef&quot;:&quot;0.37&quot;,&quot;created_at&quot;:&quot;2023-12-15T14:46:41.000000Z&quot;,&quot;updated_at&quot;:&quot;2025-02-14T06:18:23.000000Z&quot;,&quot;margin&quot;:0,&quot;diskon&quot;:0},&quot;baki&quot;:&quot;-&quot;,&quot;action&quot;:&quot;<a id=\&quot;Show\&quot; href=\&quot;http://localhost:8000/products/show_sertifikat/508\&quot; class=\&quot;btn btn-outline-primary btn-sm\&quot;>\n    <i class=\&quot;bi bi-plus\&quot;></i>\n</a>    &quot;,&quot;product_image&quot;:&quot;<div class=\&quot;p-0 object-center\&quot;>\n<a href=\&quot;http://localhost:8000/storage/uploads/1742774180.png\&quot; data-lightbox=\&quot;1742774180.png \&quot; class=\&quot;single_image\&quot;>\n    <img src=\&quot;http://localhost:8000/storage/uploads/1742774180.png\&quot; order=\&quot;0\&quot; width=\&quot;70\&quot; class=\&quot;img-thumbnail\&quot;/>\n</a>\n </div>&quot;,&quot;tracking&quot;:&quot;<div class=\&quot;flex row justify-center items-center\&quot;>\n\n<a href=\&quot;http://localhost:8000/products/qrcode/pkgr3mg6\&quot; id=\&quot;QrCode\&quot; class=\&quot;btn btn-outline-info btn-sm\&quot;>\n  <i class=\&quot;bi bi-upc\&quot;></i> Qr Code\n</a>\n\n</div>\n&quot;,&quot;cabang&quot;:&quot;<div class=\&quot;text-center items-center gap-x-2\&quot;>\n                            <div class=\&quot;text-sm text-center\&quot;>\n                              </div>\n                                </div>&quot;,&quot;rekomendasi&quot;:&quot;<div class=\&quot;items-center gap-x-2\&quot;>\n                                <div class=\&quot;text-sm text-center text-gray-500\&quot;>\n                                Rp .555,000 <br>\n                                </div>\n                                </div>&quot;}">Add</button>
        {
            data: null,
            className: 'text-center',
            render: function(data, type, row, meta) {
                // return `<button class="btn btn-sm btn-success btn-add-to-preview" data-row='${JSON.stringify(row)}'>Move</button>`;
                return `<a href="./update/{{$id}}/${row.id}" class="btn btn-sm btn-success btn-add-to-preview" data-row='${JSON.stringify(row)}' onclick="confirm('Yakin Pindah Baki');">Move</a>`;
            }
        },

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
    .appendTo("#buttons"); 

    function sum_harga(){
        let total = 0;

        $('input[name="harga[]"]').each(function () {
            const value = parseFloat($(this).val());

            if (!isNaN(value)) {
                total += value;
            }
        });

        // Format and update total display
        $('#total-nominal').text(`Rp ${formatRupiah(total)}`);
    }

    function formatRupiah(number) {
        return number.toLocaleString('id-ID');
    }

    $('#btn-delete-last').on('click', function () {
        const previewArea = $('#preview-area');
        const lastItem = previewArea.children().last();

        if (lastItem.length) {
            lastItem.remove();
        } else {
            alert('No items to delete!');
        }
        sum_harga();
    });

    $(document).on('click', '.btn-delete-current', function () {
        $(this).closest('.preview-item').remove();
        sum_harga();
    });


    $('#custom-product-form').on('submit', function (e) {
        e.preventDefault();

        const service   = $('#service').val().trim();
        const desc      = $('#desc').val().trim();
        const harga     = formatRupiah(parseFloat($('#harga').val()));
        const price     = $('#harga').val();
        
        if (!service || isNaN(harga)) {
            alert("Please fill out the form correctly.");
            return;
        }

        const previewArea = $('#preview-area');

        const newItem = `
            <div class="border-bottom pb-2 mb-2 preview-item">
                <div class="row align-items-center">
                    <div class="col-3">
                        <div class="text-xs text-yellow-600">${service}</div>
                        <h6 class="mb-0 small text-gray-700">${desc}</h6>
                    </div>
                    <div class="col-3">
                        <small>Rekomendasi: <strong>${harga}</strong></small>
                    </div>
                    <div class="col-2">
                        <small>Diskon: <strong>0</strong></small>
                    </div>
                    <div class="col-3">
                        <input type="hidden" name="product[]" value="0">
                        <input type="hidden" name="product_name[]" value="${service}">
                        <input type="hidden" name="product_desc[]" value="${desc}">
                        <input type="number" name="harga[]" class="form-control form-control-sm" onkeyup="sum_harga();" value="${price}" placeholder="Harga">
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-current">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        previewArea.append(newItem);
        sum_harga();

        // Reset and hide modal
        $('#custom-product-form')[0].reset();
        // const modalEl = document.getElementById('customProductModal');
        // const modal = bootstrap.Modal.getInstance(modalEl);
        // modal.hide();
    });


    $(document).on('click', '.btn-add-to-preview', function() {
        let rowData = $(this).attr('data-row');
    
        try {
            // console.log(rowData);
            rowData = JSON.parse(rowData);
            renderPreview(rowData);
        } catch (e) {
            console.error('Failed to parse row data', e);
        }
    });

    function renderPreview(data) {
        // console.log(data);
        const previewArea = $('#preview-area');
        const rekomendasi = formatRupiah(data.harga * data.karats.coef);
        const price       = (data.harga * data.karats.coef);
        const product     = (data.id);
        const newItem = `
        <div class="border-bottom pb-2 mb-2 preview-item">
            <div class="row align-items-center">
                <div class="col-3">
                    <h6 class="mb-0 small text-gray-700">${data.product_name}</h6>
                </div>
                <div class="col-3">
                    <small>Rekomendasi: <strong>${rekomendasi}</strong></small>
                </div>
                <div class="col-2">
                    <small>Diskon: <strong>0</strong></small>
                </div>
                <div class="col-3">
                    <input type="hidden" name="product[]" value="${product}">
                    <input type="hidden" name="product_name[]" value="${data.category.category_name}">
                    <input type="hidden" name="product_desc[]" value="${data.category.category_name}">
                    <input type="number" name="harga[]" class="form-control form-control-sm" value="${price}" onkeyup="sum_harga();" placeholder="Harga">
                </div>
                <div class="col-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-current">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>`;

        previewArea.append(newItem);
        sum_harga();
    }
        $(document).ready(function () {
            // $('#checkoutModal').modal('show');
            window.addEventListener('showCustomModal', event => {
                $('#customModal').modal('show');
            });
            window.addEventListener('showCheckoutModal', event => {
                $('#checkoutModal').modal('show');

                // $('#paid_amount').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: false,
                //     precision: 0,
                // });  

                // $('#discount').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: false,
                //     precision: 0,

                // });

                // $('#total_amount').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     precision: 0,
                //     allowZero: false,
                // });

                //  $('#grand_total').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });
                 
                //  $('#final').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });

                //  $('#input_tunai').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });

                //  $('#input_cicilan').maskMoney({
                //     prefix:'{{ settings()->currency->symbol }}',
                //     thousands:'{{ settings()->currency->thousand_separator }}',
                //     decimal:'{{ settings()->currency->decimal_separator }}',
                //     allowZero: true,
                //     precision: 0,
                // });


                // $('#paid_amount').maskMoney('mask');
                // $('#total_amount').maskMoney('mask');
                // $('#grand_total').maskMoney('mask');
                // $('#discount').maskMoney('mask');
                // $('#final').maskMoney('mask');

                // $('#checkout-form').submit(function () {
                //     var paid_amount = $('#paid_amount').maskMoney('unmasked')[0];
                //     $('#paid_amount').val(paid_amount);

                //     var total_amount = $('#total_amount').maskMoney('unmasked')[0];
                //     $('#total_amount').val(total_amount); 

                //     var discount = $('#discount').maskMoney('unmasked')[0];
                //     $('#discount').val(discount);
                // });
            });
            window.addEventListener('cart:empty', event => {
                toastr.error(event.detail.message);
            });
            window.addEventListener('total_payment_amount', event => {
                toastr.error(event.detail.message);
            });
        });
    </script>

@endpush
