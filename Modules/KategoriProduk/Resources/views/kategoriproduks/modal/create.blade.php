<div class="px-3">
    <x-library.alert />
    <form id="FormTambah" action="{{ route("$module_name.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                 <label for="{{ $field_name }}">{{ $field_placeholder }} <span class="text-danger">*</span></label>
                <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" value="{{ old('name') }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
                </div>
                       <div class="form-group">
                             <?php
                            $field_name = 'description';
                            $field_lable = __($field_name);
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
            <label for="{{ $field_name }}">{{ $field_placeholder }} <span class="text-danger">*</span> </label>
            <textarea name="{{ $field_name }}" id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}">{{ old('description') }}</textarea>

            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
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
        function Tambah()
        {
            $.ajax({
                 url: $('#FormTambah').attr('action'),
                type: "POST",
                data: new FormData($('#FormTambah')[0]),
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
                        setTimeout(function(){ autoRefresh(); 
                            $('#btn-close').trigger('click');
                        }, 2000);
                        
                    }else{
                        printErrorMsg(data.error);
                    }
                },
                error:function(xhr,status){
                    console.log( xhr,status)
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
            var Tombol = "<button type='button' class='btn btn-danger px-5' id='btn-close' data-dismiss='modal'>{{ __('Close') }}</button>";
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
// $('#potongan_harga').maskMoney({
//            prefix: 'Rp ',
//            thousands: '.',
//            decimal: ',',
//            precision: 0
//          });
});
    })(jQuery);
</script>