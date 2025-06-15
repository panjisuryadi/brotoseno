@extends('layouts.app')

@section('title', 'POS')

@section('third_party_stylesheets')

@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">POS</li>
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
            <div class="col-md-7">
                <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th style="width: 5%!important;">No</th>
                            <th style="width: 15%!important;">{{ Label_case('image') }}</th>
                            <th style="width: 15%!important;">Code</th>
                            <th style="width: 20%!important;">{{ Label_case('product') }}</th>
                            <th style="width: 23%!important;" class="text-center">{{ Label_case('Karat | Berat') }}</th>
                            <th style="width: 17%!important;" class="text-center">{{ Label_case('Harga') }}</th>
                            <!-- <th style="width: 25%!important;" class="text-center">{{ Label_case('Date') }}</th> -->
                            <th style="width: 5%!important;" class="text-center">#</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Right Side: Selected Product + Actions -->
            <div class="col-md-5 d-flex flex-column justify-content-between border-start" style="min-height: 400px;">
                
                <!-- Placeholder for Selected Product (you'll use JS here) -->
                <!-- <div class="flex-grow-1 d-flex align-items-center justify-content-center"> -->
                <form action="./sale/insert" id="sale" method="post">
                    @csrf
                    <input type="hidden" name="customer" id="customer">
                    <div class="flex-grow-1 d-flex flex-column gap-2 overflow-auto" id="preview-area" style="max-height: 300px; /* or whatever fits your layout */overflow-y: auto;">
                        
                    <!-- <span class="text-muted">Selected product preview goes here</span> -->
                    </div>
                </form>

                <!-- Bottom Controls -->
                <div class="w-100">
                    <!-- Delete / Add Buttons -->
                    <!-- <div class="d-flex gap-2 mb-3"> -->
                    <div class="d-flex mb-3">
                        <!-- <button class="btn btn-outline-danger w-50" id="btn-delete-last">
                            <i class="hover:text-red-400 text-2xl text-gray-500 bi bi-trash"></i> Delete
                        </button> -->
                        <button class="btn btn-outline-primary w-100" id="btn-add-special" data-toggle="modal" data-target="#customProductModal">
                            <i class="hover:text-blue-400 text-2xl text-gray-500 bi bi-file-plus"></i> Custom
                        </button>
                    </div>
                    
                    <!-- Checkout / Total -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold fs-5">Total:</span>
                        <span id="total-nominal" class="fw-bold fs-4 text-success">Rp 0</span>
                    </div>
                    <button type="button" onclick="copy_div();" class="btn btn-success w-100" id="btn-checkout" form="sale" data-toggle="modal" data-target="#confirmProductModal">Checkout</button>
                </div>

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
        <div class="row">
            <div class="col-md-2">
                <label for="">Customer</label>
            </div>
            <div class="col-md-4">
                <select name="customer" id="customer_modal" class="form-control">
                    <option value="0">Pilih Customer / User Umum</option>
                @foreach($customers as $index => $c)
                    <option value="{{$c->id}}">{{$c->customer_name}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="">Payment</label>
            </div>
            <div class="col-md-4">
                <select name="payment" id="payment" class="form-control">
                    <option value="cash">Cash</option>                
                    <option value="edc">EDC</option>                
                    <option value="transfer">Transfer</option>                
                </select>
            </div>
            <hr>
        </div>
        
        <div class="mt-5" id="copy">

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
    $(document).ready(function(){
        $('#confirmProductModal').on('hidden.bs.modal', function () {
            remove_copy();
        });
    });
    function submit_form(){
        let cust = $("#customer_modal").val();
        $("#customer").val(cust);
        $("#sale").submit();
        // return true;
    }

    function copy_div(){
        let clone = $("#preview-area").clone();

        // For each diskon input inside the clone, set the 'value' attribute to the current input value
        clone.find('input[name="diskon[]"]').each(function(){
            $(this).attr('value', $(this).val());
        });

        clone.find('input[name="ongkos[]"]').each(function(){
            $(this).attr('value', $(this).val());
        });

        // Similarly, for each harga input inside the clone, update the 'value' attribute
        clone.find('input[name="harga[]"]').each(function(){
            $(this).attr('value', $(this).val());
        });

        // Remove unwanted elements in the clone
        // clone.find('input[name="diskon[]"]').remove();       // If you want to remove discount inputs in the copy
        clone.find('.btn-delete-current').remove();          // Remove delete buttons from copy

        // Now set the HTML of #copy using the clone's HTML
        $("#copy").html(clone.html());
        let total = $("#total-nominal").html();
        $("#total").html(total);

    }

    function copy_div_old(){
        // $('input[name="diskon[]"]').prop('readonly', true);
        let div = $("#preview-area").html();
        let total = $("#total-nominal").html();
        $("#copy").html(div);
        $("#total").html(total);
        $('#copy input[name="diskon[]"]').remove();
        $('#copy .btn-delete-current').remove();
    }     
    function remove_copy(){
        // $('input[name="diskon[]"]').prop('readonly', false);
        $("#copy").html('');
    }
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
        ajax: '/sale/index_data',
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
        }, {
            data: 'product_code',
            name: 'product_code'
        }, {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'karat',
            name: 'karat'
        }, 
        {
            data: 'rekomendasi',
            name: 'rekomendasi'
        }, 
        // {
        //     data: 'created_at',
        //     name: 'created_at'
        // },
        {
            data: null,
            className: 'text-center',
            render: function(data, type, row, meta) {
                return `<button class="btn btn-sm btn-success btn-add-to-preview" data-row='${JSON.stringify(row)}'>Add</button>`;
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

    function sum_diskon() {
        const ongkosInputs = document.querySelectorAll('input[name="ongkos[]"]');
        const diskonInputs = document.querySelectorAll('input[name="diskon[]"]');
        const hargaInputs = document.querySelectorAll('input[name="harga[]"]');

        diskonInputs.forEach((diskonInput, index) => {
            const hargaInput = hargaInputs[index];
            const ongkosInput = parseInt(ongkosInputs[index].value) || 0;
            console.log(ongkosInput);
            if (!hargaInput) return;

            const originalHarga = parseInt(hargaInput.getAttribute('data-original-harga')) || 0;
            let diskonVal = parseInt(diskonInput.value) || 0;

            // Ensure discount is not negative or above max
            if (diskonVal < 0) diskonVal = 0;
            const maxDiskon = parseInt(diskonInput.getAttribute('max')) || diskonVal;
            if (diskonVal > maxDiskon) {
            diskonVal = maxDiskon;
            diskonInput.value = maxDiskon; // correct the input value
            }

            // Calculate the new harga after discount
            let newHarga = originalHarga - diskonVal + ongkosInput;
            // let newHarga = originalHarga - diskonVal;
            if (newHarga < 0) newHarga = 0; // prevent negative harga

            hargaInput.value = newHarga;
        });
        sum_harga();
    }

    function sum_ongkos() {
        const ongkosInputs = document.querySelectorAll('input[name="ongkos[]"]');
        const diskonInputs = document.querySelectorAll('input[name="diskon[]"]');
        const hargaInputs = document.querySelectorAll('input[name="harga[]"]');

        ongkosInputs.forEach((ongkosInput, index) => {
            const hargaInput = hargaInputs[index];
            const diskonInput = parseInt(diskonInputs[index].value) || 0;
            console.log(diskonInput);
            if (!hargaInput) return;

            const originalHarga = parseInt(hargaInput.getAttribute('data-original-harga')) || 0;
            let ongkosVal = parseInt(ongkosInput.value) || 0;

            // Ensure discount is not negative or above max
            // if (diskonVal < 0) diskonVal = 0;
            // const maxDiskon = parseInt(ongkosInput.getAttribute('max')) || diskonVal;
            // if (diskonVal > maxDiskon) {
            // diskonVal = maxDiskon;
            // ongkosInput.value = maxDiskon; // correct the input value
            // }

            // Calculate the new harga after discount
            let newHarga = originalHarga + ongkosVal - diskonInput;
            if (newHarga < 0) newHarga = 0; // prevent negative harga

            hargaInput.value = newHarga;
        });
        sum_harga();
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
        const diskon    = $('#diskon').val();
        const min       = price-diskon;
        
        if (!service || isNaN(harga)) {
            alert("Please fill out the form correctly.");
            return;
        }

        const previewArea = $('#preview-area');

        const newItem = `
            <div class="border-bottom pb-2 mb-2 preview-item">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="text-xs text-blue-600">${service}</div>
                        <h6 class="mb-0 small text-gray-700">${desc}</h6>
                    </div>
                    <div class="col-3">
                        <small>Harga: <strong>${harga}</strong></small>
                    </div>
                    <div class="col-2">
                        <input type="number" name="diskon[]" class="form-control form-control-sm" value="0" max="0" readonly>
                    </div>
                    <div class="col-2">
                        <input type="number" name="ongkos[]" class="form-control form-control-sm" value="0" max="0" readonly>
                    </div>
                    <div class="col-2">
                        <input type="hidden" name="product[]" value="0">
                        <input type="hidden" name="product_name[]" value="${service}">
                        <input type="hidden" name="product_desc[]" value="${desc}">
                        <input type="number" name="harga[]" class="form-control form-control-sm" data-original-harga="${price}" onkeyup="sum_harga();" value="${price}" placeholder="Harga" readonly>
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
        const harga       = ((data.harga*data.karats.coef)+(data.harga*data.karats.coef*data.karats.persen/100))*data.berat_emas;
        const rekomendasi = formatRupiah(harga);
        const price       = (harga);
        const diskon      = Math.round((data.karats.diskon)*data.berat_emas);
        const min         = (price-diskon);
        const product     = (data.id);
        const newItem = `
        <div class="border-bottom pb-2 mb-2 preview-item">
            <div class="row align-items-center">
                <div class="col-2">
                    <h6 class="mb-0 small text-gray-700">${data.product_name}</h6>
                </div>
                <div class="col-2">
                    <small>Harga: <strong>${rekomendasi}</strong></small>
                </div>
                <div class="col-1">
                    <small>Max Disc: <strong>${diskon}</strong></small>
                </div>
                <div class="col-2">
                    <label>Disc</label>
                    <input type="number" name="diskon[]" class="form-control form-control-sm" value="0" max="${diskon}" onkeyup="sum_diskon();" placeholder="Diskon">
                </div>
                <div class="col-2">
                    <label>Ongkos</label>
                    <input type="number" name="ongkos[]" class="form-control form-control-sm" value="0" onkeyup="sum_ongkos();" placeholder="Diskon">
                </div>
                <div class="col-2">
                    <input type="hidden" name="product[]" value="${product}">
                    <input type="hidden" name="product_name[]" value="${data.category.category_name}">
                    <input type="hidden" name="product_desc[]" value="${data.category.category_name}">
                    <input type="number" name="harga[]" class="form-control form-control-sm" data-original-harga="${price}" value="${price}" onkeyup="sum_harga();" placeholder="Harga" readonly>
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
