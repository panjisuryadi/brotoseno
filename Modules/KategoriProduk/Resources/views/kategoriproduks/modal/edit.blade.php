  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.update', $detail) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

      <div class="flex row px-4">
                        <div class="w-1/3 text-center items-center">
                            <div x-data="{photoName: null, photoPreview: null}" class="justify-center form-group">
                                <?php
                                $field_name = 'image';
                                $field_lable = __($field_name);
                                $label = Label_Case($field_lable);
                                $field_placeholder = $label;
                                $required = '';
                                ?>
                                <input type="file" name="{{ $field_name }}" accept="image/*" class="hidden" x-ref="photo" x-on:change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                                ">
                                <div class="text-center">
                                    <div class="mt-2 py-2" x-show="! photoPreview">
                                        <img src="{{asset("images/logo.png")}}" class="w-40 h-40 m-auto rounded-xl ">
                                    </div>
                                    <div class="mt-2 py-2" x-show="photoPreview" style="display: none;">
                                        <span class="block w-40 h-40 rounded-xl m-auto" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
                                        </span>
                                    </div>
                                    <button type="button" class="btn btn-secondary px-5" x-on:click.prevent="$refs.photo.click()">
                                    @lang('Select Image')
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="w-2/3">
                           <div class="form-group">
                  <?php
                    $field_name = 'name';
                    $field_lable = __($field_name);
                    $field_placeholder = Label_case($field_lable);
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = '';
                    ?>
                 <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" value="{{ $detail->name }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                    @if ($errors->has($field_name))
                        <span class="invalid feedback"role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                class="text-danger">
                        </span>
                    @endif
                </div>
                       <div class="form-group">
                             <?php
                            $field_name = 'description';
                            $field_lable = __($field_name);
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
            <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <textarea name="{{ $field_name }}" id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}">{{ $detail->description }}</textarea>

               @if ($errors->has($field_name))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                        class="text-danger">
                                </span>
                            @endif
                            </div>
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
            data: new FormData($('#FormEdit')[0]),
            processData: false,
            contentType: false,
            cache: false,
            mimeType:'multipart/form-data',
            dataType:'json',
            success: function(data) {
                  console.log(data.error)
                    if($.isEmptyObject(data.error)){
                      $('#ResponseInput').html(data.success);
                      $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                      $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                      setTimeout(function(){ autoRefresh(); }, 1000);
                      setTimeout(function () {
                              $('#btn-close').trigger('click');
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

    var Tombol = "<button type='button' id='btn-close' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
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