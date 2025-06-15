  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.update', $detail) }}" method="POST">
                            @csrf
                            @method('patch')
             <div class="flex flex-row grid grid-cols-1 gap-4">
                          <div class="form-group">
                                        <label for="user_id">Users <span class="text-danger">*</span></label>
                                        <select class="form-control" name="user_id" id="user_id" required>
                                            @foreach(\app\Models\User::all() as $main)
                                                <option {{ $main->id == $detail->user_id ? 'selected' : '' }} value="{{ $main->id }}">{{ $main->name }}</option>
                                            @endforeach
                                        </select>
                    <div class="invalid feedback" role="alert">
                         <span class="text-danger error-text user_id_err"></span>
                    </div>

                                    </div>

                       <div class="form-group">
                                <?php
                                $field_name = 'name';
                                $field_lable = label_case('Company');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" type="text"
                        name="{{ $field_name }}"
                        id="{{ $field_name }}"
                        value="{{$detail->name }}">
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

 function autoRefresh(){
      var table = $('#datatable').DataTable();
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
     // $('#potongan_harga').maskMoney({
     //            prefix: 'Rp ',
     //            thousands: '.',
     //            decimal: ',',
     //            precision: 0
     //          });

});
})(jQuery);
</script>