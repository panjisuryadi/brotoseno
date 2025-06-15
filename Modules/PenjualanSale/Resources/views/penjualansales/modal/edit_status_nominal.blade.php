@php
    $dibayar = 0;
    $isCicil = ($data->tipe_pembayaran == 'cicil') ? true : false;
    foreach ($data->detailCicilan as $key => $value) {
        $dibayar += $value->nominal;
    }
    $total_harus_bayar = $data->penjualanSales->total_nominal - $dibayar;
    $sisa_cicilan = $data->sisa_cicilan ?? 0;
@endphp
<div class="px-3 mb-3">
    <x-library.alert />

    <form id="FormEdit" action="{{ route(''.$module_name.'.update_status_pembelian' )}}" method="POST">
        @csrf
        @method('post')
        
        <div class="form-group mb-0">
            <input class="form-control" type="hidden" name="pembelian_id" id="" value="{{ $data->id }}">
            <input class="form-control" type="hidden" name="harga_type" id="" value="{{ $data->penjualanSales->harga_type }}">
        </div>
        <span class="text-danger"> Hutang Rp. {{ rupiah($total_harus_bayar) }} </span>

        <div class="flex flex-row grid grid-cols-1 gap-4 mt-4">
            <input class="form-control" type="hidden" name="tgl_jatuh_tempo" value="{{ $data->jatuh_tempo }}" id="">
            <input class="form-control" type="hidden" name="is_cicilan" id="" value="0">
            <input class="form-control" type="hidden" name="total_harus_bayar" id="" value="{{ $total_harus_bayar }}">

            <div class="form-group mb-0">
                <input type="radio" id="tipe_nominal" name="tipe" value="tipe_nominal" checked>
                <label for="tipe_nominal">Nominal</label>
                <input type="radio" id="rongsok" name="tipe" value="rongsok">
                <label for="rongsok">Rongsok</label>
                <input type="radio" id="lantakan" name="tipe" value="lantakan">
                <label for="lantakan">Lantakan</label>
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text tipe_err"></span>
                </span>
            </div>

            <div class="form-group mb-0" id="form_karat_id">
                @php
                    $field_name = 'karat_id';
                    $field_lable = label_case('Karat Rongsok');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                @endphp
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <select class="form-control form-control-sm" name="{{ $field_name }}" id="{{ $field_name }}">
                    <option value="" selected >Select Karat</option>
                    @foreach($dataKarat as $karat)
                    <option value="{{$karat->id}}">
                        {{$karat?->label}}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-0" id="form_berat">
                @php
                    $field_name = 'berat';
                    $field_lable = label_case('Berat Rongsok');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                @endphp
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="0" >
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div>

            <div class="form-group mb-0" id="form_harga">
                @php
                    $field_name = 'harga';
                    $field_lable = label_case('Harga %');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                @endphp
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="0" >
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div>

            <div class="form-group mb-0" id="form_jumlah_cicilan">
                <?php
                    $field_name = 'jumlah_cicilan';
                    $field_lable = label_case('Berat bersih');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                ?>
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="">
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div>

            <div class="form-group mb-0" id="form_gold_price">
                <?php
                    $field_name = 'gold_price';
                    $field_lable = label_case('Harga Emas');
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

            <div class="form-group mb-0" id="form_nominal">
                <?php
                    $field_name = 'nominal';
                    $field_lable = label_case('Nominal');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                ?>
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="0" readonly>
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div>
        </div>
            
    </form>


</div>
{{-- <script src="{{ asset('js/jquery-mask-money.js') }}"></script> --}}
<script>
jQuery.noConflict();
(function( $ ) {

    $(document).ready(function(){
        // init form
        formClear();
        formNominal();

        var Tombol = "<button type='button' id='tombol_close' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
        Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanUpdate'>{{ __('Simpan') }}</button>";
        $('#ModalFooter').html(Tombol);

        $("#FormEdit").find('input[type=text],textarea,select').filter(':visible:first').focus();

        $('#SimpanUpdate').click(function(e){
            e.preventDefault();
            Update();
        });

        $('#FormEdit').submit(function(e){
            e.preventDefault();
            Update();
        });
        $('input[type=radio][name=tipe]').change(function() {
            if (this.value == 'rongsok') {
                formRongsok()
            }
            else if (this.value == 'lantakan') {
                formLantakan()
            }else if(this.value == 'tipe_nominal'){
                formNominal()
            }
        });

    });

    function setKonveriEmas(){
        let jumlah_cicilan = $('#jumlah_cicilan').val() ? $('#jumlah_cicilan').val() : 0;
        let hargaEmas = $('#gold_price').val() ? $('#gold_price').val() : 0;
        let nominal = jumlah_cicilan * hargaEmas;
        $('#nominal').val(nominal)
    }

    function setKonveriEmasRongsok(){
        let berat = $('#berat').val() ? $('#berat').val() : 0;
        let hargaEmas = $('#gold_price').val() ? $('#gold_price').val() : 0;
        let nominal = berat * hargaEmas;
        $('#nominal').val(nominal)
    }

    $(document).on('change', '#jumlah_cicilan, #gold_price', function(e){
        if($('input[type=radio][name=tipe]:checked').val() == 'lantakan'){
            setKonveriEmas();
        }
    })

    $(document).on('change', '#gold_price, #berat', function(e){
        if($('input[type=radio][name=tipe]:checked').val() == 'rongsok'){
            setKonveriEmasRongsok();
        }
    })
        
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

    function formNominal(){
        $('#form_nominal').show()
        $('#form_gold_price').hide()
        $('#form_karat_id').hide()
        $('#form_berat').hide()
        $('#form_harga').hide()
        $('#form_jumlah_cicilan').hide()
        $('#nominal').prop('readonly', false)

    }

    function formRongsok(){
        $('#form_nominal').show()
        $('#form_gold_price').hide()
        $('#form_karat_id').show()
        $('#form_berat').show()
        $('#form_gold_price').show()
        $('#form_jumlah_cicilan').hide()
        $('#nominal').prop('readonly', true)
    }

    function formLantakan(){
        $('#form_karat_id').hide()
        $('#form_berat').hide()
        $('#form_harga').hide()
        $('#form_jumlah_cicilan').show()
        $('#form_gold_price').show()
        $('#form_nominal').show()
        $('#nominal').prop('readonly', true)
    }

    function formClear(){
        $('#nominal').prop('readonly', false)
        $('#form_gold_price').hide()
        $('#form_karat_id').hide()
        $('#form_berat').hide()
        $('#form_harga').hide()
        $('#form_jumlah_cicilan').hide()
    }

})(jQuery);
</script>