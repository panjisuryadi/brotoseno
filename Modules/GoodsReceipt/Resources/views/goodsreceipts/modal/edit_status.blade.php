@php
    $dibayar = 0;
    $dibayar_nominal = 0;
    $isCicil = ($data->tipe_pembayaran == 'cicil') ? true : false;
    if($data->tipe_pembayaran == 'cicil') {
        foreach ($data->detailCicilan as $key => $value) {
            $dibayar += $value->jumlah_cicilan;
            $dibayar_nominal += $value->nominal;
        }
    }
    $total_harus_bayar = number_format($data->goodreceipt->total_emas, 2) - $dibayar;
    $harga_beli = $data->goodreceipt->harga_beli ?? 0;
    $sisa_cicilan = $data->sisa_cicilan ?? 0;
    $isBerlian = $data->goodreceipt->kategoriproduk_id == $kategoriproduk_id ? true : false;
    $total_harus_bayar_nominal = $harga_beli-$dibayar_nominal;
@endphp
<div class="px-3">
    <x-library.alert />
    @if(!empty($total_harus_bayar) && $isCicil )
        <span class="text-dark"> Total emas yang harus dibayarkan </span> <span class="ml-1 text-danger"> {{  $total_harus_bayar }}</span>
    @endif

    @if(!empty($harga_beli) && $isCicil && $isBerlian )
        <span class="text-dark"> Total yang harus dibayarkan </span> <span class="text-danger">  Rp. / $ {{ number_format($total_harus_bayar_nominal) }}. </span>
    @endif


    <form id="FormEdit" action="{{ route(''.$module_name.'.update_status_pembelian' )}}" method="POST">
        @csrf
        @method('post')
        
        <div class="form-group">
            <input class="form-control" type="hidden" name="pembelian_id" id="" value="{{ $data->id }}">
            <input class="form-control" type="hidden" name="is_berlian" id="" value="{{ $isBerlian }}">
            <input class="form-control" type="hidden" name="total_harus_bayar_nominal" id="" value="{{ $total_harus_bayar_nominal }}">
        </div>
        @if($isCicil)
            <div class="flex flex-row grid grid-cols-1 gap-2">
                <div class="form-group">
                    <label for="cicilan_id">@lang('Pilih Cicilan') <span class="text-danger">*</span></label>
                    <select class="form-control" name="cicilan_id" id="cicilan_id" required>
                        <option value="" selected disabled >Pilih Cicilan </option>
                        @foreach($data->detailCicilan as $item)
                            @if ( empty($item->jumlah_cicilan) && empty($item->nominal))
                                <option value="{{ $item->id }}">Cicilan ke - {{ $item->nomor_cicilan }} {{ date('d/m/y', strtotime($item->tanggal_cicilan)) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @if(!$isBerlian)


                <div class="form-group">

                    <input type="radio" id="tipe_nominal" name="tipe" value="tipe_nominal" checked>
                    <label for="tipe_nominal">Nominal</label>
                    <input type="radio" id="emas" name="tipe" value="emas">
                    <label for="emas">{{ label_case('emas') }}</label>
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text tipe_err"></span>
                    </span>
                </div>
                <div class="form-group" id="form_jumlah_cicilan">
                    <?php
                        $field_name = 'jumlah_cicilan';
                        $field_lable = label_case('Berat');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="" >
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
                @endif
                <div class="form-group" id="form_nominal">
                    <?php
                        $field_name = 'nominal';
                        $field_lable = label_case('Nominal');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="" >
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
                <div class="form-group">
                    <input class="form-control" type="hidden" name="is_cicilan" id="" value="1">
                    <input class="form-control" type="hidden" name="sisa_cicilan" id="" value="{{ $sisa_cicilan }}">
                    <input class="form-control" type="hidden" name="total_harus_bayar" id="" value="{{ $total_harus_bayar }}">
                </div>
            </div>
        @else
        <span class="text-dark mb-4"> Tanggal jatuh tempo <span class="ml-1 text-warning">  {{ $data->jatuh_tempo }} 23:59 </span> @if(!$isBerlian) Jumlah yang harus dibayar {{ $total_harus_bayar }}gr @endif <span class="text-danger"> {{ !empty($harga_beli) ? ' Harga Beli Rp. ' . number_format($harga_beli) : '' }}. </span>

        <div class="flex flex-row grid grid-cols-2 gap-4 mt-4">
            <div class="form-group">
                <input class="form-control" type="hidden" name="tgl_jatuh_tempo" value="{{ $data->jatuh_tempo }}" id="">
                <input class="form-control" type="hidden" name="is_cicilan" id="" value="0">
                <input class="form-control" type="hidden" name="total_harus_bayar" id="" value="{{ $total_harus_bayar }}">

                @if(!$isBerlian)
                <div class="form-group">

                    <input type="radio" id="tipe_nominal" name="tipe" value="tipe_nominal" checked>
                    <label for="tipe_nominal">Nominal</label>
                    <input type="radio" id="emas" name="tipe" value="emas">
                    <label for="emas">{{ label_case('emas') }}</label>
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text tipe_err"></span>
                    </span>
                </div>
                <div class="form-group" id="form_jumlah_cicilan">
                    <?php
                        $field_name = 'jumlah_cicilan';
                        $field_lable = label_case('Berat');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="" >
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>

                @endif
                <div class="form-group" id = "form_nominal">
                    <?php
                        $field_name = 'nominal';
                        $field_lable = label_case('Nominal');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="" >
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
            </div>
        </div>
            
        @endif
    </form>


</div>
{{-- <script src="{{ asset('js/jquery-mask-money.js') }}"></script> --}}
<script>
jQuery.noConflict();
(function( $ ) {

function autoRefresh(){
    table.ajax.reload();
}

function Update()
{
    $.ajax({
        url: $('#FormEdit').attr('action'),
        type: "POST",
        cache: false,
        data: $('#FormEdit').serialize(),
        dataType:'json',
        success: function(data) {
                if($.isEmptyObject(data.error)){
                    $('#ResponseInput').html(data.success);
                    $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                    $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                    setTimeout(function(){ autoRefresh(); }, 1000);
                    setTimeout(function () {
                            $('#tombol_close').trigger('click');
                        }, 3000);

                }else{
                    printErrorMsg(data.error);
                }
            }
    });
}

function printErrorMsg (msg) {
    $.each( msg, function( key, value ) {
        $('#'+key+'').addClass("");
        $('#'+key+'').addClass("is-invalid");
        $('.'+key+'_err').text(value);

    });
}

$(document).ready(function(){

    var Tombol = "<button type='button' id='tombol_close' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
    Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanUpdate'>{{ __('Simpan') }}</button>";
    $('#ModalFooter').html(Tombol);

    $("#FormEdit").find('input[type=text],textarea,select').filter(':visible:first').focus();

    $('#SimpanUpdate').click(function(e){
        e.preventDefault();
        let nominal = $("#nominal").val();
        let harga_beli = "{{ $harga_beli }}";
        let isCicil = "{{ $isCicil }}";
        if(!isCicil && harga_beli != 0 && nominal != harga_beli && nominal != 0){
            const formatter = new Intl.NumberFormat('en');
            if(confirm(`Harga beli yang diinputkan di penerimaan Rp. (${formatter.format(harga_beli)}) , apakah akan diupdate dengan nominal sekarang Rp. (${formatter.format(nominal)})`)) {
                Update();
            }
        }else{
            Update();
        }
    });

    
    $('input[type=radio][name=tipe]').change(function() {
        if (this.value == 'emas') {
            formEmas()
        }else if(this.value == 'tipe_nominal'){
            formNominal()
        }
    });

    $('#FormEdit').submit(function(e){
        e.preventDefault();
        Update();
    });

    function formNominal(){
        $('#form_nominal').show()
    }

    function formEmas(){
        $('#form_nominal').hide()
    }

});
})(jQuery);
</script>