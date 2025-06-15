<div class="px-3 border-left">
    <x-library.alert />
    <form id="FormTambah" action="{{ route('products.saveajax') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @php
        $code = \Modules\Product\Entities\Product::generateCode();
        @endphp
        <input type="hidden" class="form-control" name="product_code" value="{{ $code }}">
            <input type="hidden" name="product_barcode_symbology" value="C128">
            <input type="hidden" name="product_stock_alert" value="5">
            <input type="hidden" name="product_quantity" value="1">
            <input type="hidden" name="product_unit" value="Gram">
        <div class="flex flex-row grid grid-cols-2 gap-4">
            <div class="p-1">
                <div class="form-group">
                    <div class="py-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                            <label class="form-check-label" for="up2">Upload</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="upload"
                            id="up1">
                            <label class="form-check-label" for="up1">Webcam</label>
                        </div>
                    </div>
                    <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center">
                        <x-library.webcam />
                    </div>
                    <div id="upload1" style="display: block !important;" class="align-items-center justify-content-center">
                        <div class="h-160 dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                            <div class="dz-message" data-dz-message>
                                <i class="text-red-800 bi bi-cloud-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-1">
                <div class="form-group">
                    <?php
                    $field_name = 'product_name';
                    $field_lable = label_case('Nama Product');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="text"
                    name="{{ $field_name }}"
                    value="{{ old($field_name) }}"
                    placeholder="{{ $field_placeholder }}">
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
                <div class="form-group">
                    <?php
                    $field_name = 'product_price';
                    $field_lable = label_case($field_name);
                    $field_placeholder =$field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control"
                    min="0"
                    value="{{ old($field_name) }}"
                    id="{{ $field_name }}"
                    placeholder="{{ $field_placeholder }}" type="text" name="{{ $field_name }}">
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
                <div class="form-group">
                    <?php
                    $field_name = 'product_sale';
                    $field_lable = label_case($field_name);
                    $field_placeholder =$field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control"
                    min="0"
                    id="{{ $field_name }}"
                    value="{{ old($field_name) }}"
                    placeholder="{{ $field_placeholder }}" type="text" name="{{ $field_name }}">
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
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
                        $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                        $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                        setTimeout(function(){ autoRefresh(); }, 1000);
                        $('#FormTambah').each(function(){
                            this.reset();
                        });
                        setTimeout(function () {
                            $('#ModalGue').modal('hide');
                        }, 3000);
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
        $('#product_price').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
        });
        $('#product_sale').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
        });
        $('#up1').change(function() {
            $('#upload2').toggle();
            $('#upload1').hide();
        });
        $('#up2').change(function() {
            $('#upload1').toggle();
            $('#upload2').hide();
        });
    })(jQuery);
</script>