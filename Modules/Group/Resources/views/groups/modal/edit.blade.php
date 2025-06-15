  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.update', $detail) }}" method="POST">
                            @csrf
                            @method('patch')
          <div class="flex flex-row grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="flex flex-row grid grid-cols-3 gap-1">
                    <div class="form-group">
                        <?php
                        $field_name = 'code';
                        $field_lable = label_case('Kode Group');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                        ?>
                        <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input value="{{ $detail->code }}" class="form-control" type="text" name="{{ $field_name }}"
                        placeholder="{{ $field_placeholder }}">
                        <span class="invalid feedback" role="alert">
                            <span class="text-danger error-text {{ $field_name }}_err"></span>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="jenis_group_id">@lang('Jenis Group') <span class="text-danger">*</span></label>
                        <select class="form-control" name="jenis_group_id" id="jenis_group_id" required>
                            <option value="" selected disabled>Select Jenis Group</option>
                            @foreach(\Modules\JenisGroup\Models\JenisGroup::all() as $jg)
                             <option {{ $jg->id == $detail->jenis_group_id ? 'selected' : '' }}
                              value="{{ $jg->id }}">{{ $jg->code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <?php
                        $field_name = 'name';
                        $field_lable = label_case('Nama Group');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                        ?>
                        <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input value="{{ $detail->name }}" class="form-control" type="text" name="{{ $field_name }}"
                        placeholder="{{ $field_placeholder }}">
                        <span class="invalid feedback" role="alert">
                            <span class="text-danger error-text {{ $field_name }}_err"></span>
                        </span>
                    </div>
                </div>
            </div>
            {{-- <div class="form-group">
                <?php
                $field_name = 'harga';
                $field_lable = label_case($field_name);
                $field_placeholder =$field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = "required";
                ?>
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control"
                min="1"
                id="{{ $field_name }}"
                value="{{ number_format($detail->harga) }}"
                placeholder="{{ $field_placeholder }}" type="text" name="{{ $field_name }}">
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>

            </div>
            <div class="form-group">
                <?php
                $field_name = 'harga_modal';
                $field_lable = label_case($field_name);
                $field_placeholder =$field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = "required";
                ?>
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control"
                min="1"
                id="{{ $field_name }}"
                value="{{ number_format($detail->harga_modal) }}"
                placeholder="{{ $field_placeholder }}" type="text" name="{{ $field_name }}">
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div> --}}



                    </div>

            </form>


</div>
{{-- <script src="{{  asset('js/jquery.min.js') }}"></script> --}}
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
<script>
jQuery.noConflict();
(function( $ ) {

 function autoRefresh(){
    //   var table = $('#datatable').DataTable();
    //   table.ajax.reload();
    location.reload();
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
                  console.log(data.error)
                    if($.isEmptyObject(data.error)){
                      $('#ResponseInput').html(data.success);
                      $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                      $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                      setTimeout(function(){ autoRefresh(); }, 1000);
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









})(jQuery);
</script>

