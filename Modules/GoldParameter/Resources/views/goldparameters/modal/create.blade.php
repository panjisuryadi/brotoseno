<div class="px-3">
    <x-library.alert />
    <form id="FormTambah" action="{{ route("$module_name.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-row grid grid-cols-3 gap-4">
            <div class="form-group">
                <label for="group_id">@lang('Jenis Group') <span class="text-danger">*</span></label>
                <select class="form-control" name="group_id" id="group_id" required>
                    <option value="" selected disabled>@lang('Select Kode Group')</option>
                    @foreach(\Modules\Group\Models\Group::all() as $jg)
                    <option value="{{ $jg->id }}">{{ $jg->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <?php
                $field_name = 'harga';
                $field_lable = label_case('harga');
                $field_placeholder = $field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = "required";
                ?>
                <label for="{{ $field_name }}">
                    {{ $field_lable }} &nbsp;<small class="text-danger">Gram</small>
                </label>
                <input class="form-control"
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                value="{{ old($field_name) }}"
                placeholder="{{ $field_placeholder }}">
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div>
            <div class="form-group">
                <?php
                $field_name = 'harga_modal';
                $field_lable = label_case('harga_modal');
                $field_placeholder = $field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = "required";
                ?>
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control"
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                value="{{ old($field_name) }}"
                placeholder="{{ $field_placeholder }}">
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
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

 $('#harga').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
          });


 $('#harga_modal').maskMoney({
            prefix: 'Rp ',
            thousands: '.',
            decimal: ',',
            precision: 0
          });




});
})(jQuery);
</script>