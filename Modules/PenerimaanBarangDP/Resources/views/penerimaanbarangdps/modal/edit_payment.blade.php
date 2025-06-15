<div class="px-3">
    <x-library.alert />
    @if(!empty($remainder) )
        <span class="text-dark"> Sisa nominal yang harus dibayarkan </span> <span class="ml-1 text-danger"> {{ format_uang($remainder) }} </span>
    @endif


    <form id="FormEdit" action="{{ route(''.$module_name.'.update_payment' )}}" method="POST">
        @csrf
        @method('post')
        
        <div class="form-group">
            <input class="form-control" type="hidden" name="payment_id" id="" value="{{ $data->id }}">
        </div>
            <div class="form-group">
                @if ($type === 2)
                <p>Cicilan ke - {{ $data->order_number }}</p>
                @endif
                <p class="font-bold">Jatuh Tempo : {{ $data->due_date }}</p>
            </div>
            <div class="flex flex-row grid grid-cols-2 gap-4">
                
                <div class="form-group">
                    <?php
                        $field_name = 'nominal';
                        $field_lable = label_case('nominal');
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
                <div class="form-group">
                    <?php
                        $field_name = 'box_fee';
                        $field_lable = label_case('biaya box');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}</label>
                    <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="0">
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
                <div class="form-group">
                    <input class="form-control" type="hidden" name="remainder" id="" value="{{ $remainder }}">
                    <input class="form-control" type="hidden" name="is_last" id="" value="{{ $is_last }}">
                </div>
            </div>
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
    Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanUpdate'>{{ __('Update') }}</button>";
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

});
})(jQuery);
</script>