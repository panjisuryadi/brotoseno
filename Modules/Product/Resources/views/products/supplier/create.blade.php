<style type="text/css">
label {
    display: inline-block;
    margin-bottom: 0.2rem !important;
}
.form-control {
    font-size: 0.9rem !important;

}
button, input, optgroup, select, textarea {
    padding: 0;
    line-height: inherit;
    color: inherit;
}
.text-danger {
	font-size: 0.6rem !important;
    color: #e55353 !important;
    line-height: 1 !important;
}

@media (min-width: 992px)
.modal-lg, .modal-xl {
    max-width: 820px !important;
}
.loading {
    pointer-events: none;
    opacity: 0.6;
}

.loading:after {
    content: '';
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #000;
    border-top-color: transparent;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

</style>

<div class="px-3">
    <x-library.alert />

<div class="flex relative mb-2">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-b border-gray-300"></div>
        </div>
        <div class="relative flex justify-left">
            <div class="bg-white pl-0 pr-3 font-semibold text-sm capitalize text-dark">Add Product Kategori <span class="px-1 hokkie font-semibold uppercase">{{ $category->category_name }}</span></div>
        </div>
    </div>


  <form id="FormTambah" action="{{ route("$module_name.saveajax") }}" method="POST" enctype="multipart/form-data">
        @csrf
  <input type="hidden" name="category_id" value="{{ $category->id }}">
  <input type="hidden" name="location_id" value="{{ $locations->id }}">
    <input type="hidden" name="product_barcode_symbology" value="C128">
    <input type="hidden" name="product_stock_alert" value="5">
    <input type="hidden" name="product_quantity" value="0">
    <input type="hidden" name="suplier_id" value="1">
    <input type="hidden" name="gudang_id" value="1">
    <input type="hidden" name="etalase_id" value="1">
    <input type="hidden" name="baki_id" value="1">
    <input type="hidden" name="status" value="3">
    <input type="hidden" name="product_unit" value="Gram">


 <div class="flex flex-row grid grid-cols-3 gap-4">


<div class="p-2">


	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="upload" value="up2" id="up2" checked>
		<label class="form-check-label" for="up2">Upload</label>
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="upload" value="up1"
		id="up1">
		<label class="form-check-label" for="up1">Webcam</label>
	</div>


   <div id="upload" class="flex flex-row grid grid-cols-1">
  <div x-data="{photoName: null, photoPreview: null}" class="items-center">
    <?php
                $field_name = 'document';
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

    <div class="text-center h-100">
      <div class="mb-1 h-full w-full rounded-xl border-dashed border-2" x-show="! photoPreview">
        <img src="{{ asset('images/logo.png') }}" class="w-40 pt-3 m-auto mt-3">
      </div>
      <div class="py-1" x-show="photoPreview" style="display: none;">
        <span class="block w-40 h-40 rounded-xl m-auto" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
        </span>
      </div>
      <button type="button" class="inline-flex btn btn-sm btn-outline-success" x-on:click.prevent="$refs.photo.click()">
      @lang('Select Image')
      </button>
    </div>
 @error('document') <span class="text-danger">{{ $message }}</span> @enderror
  </div>

      </div>


	<div id="webcam" class="d-none flex flex-row grid grid-cols-1">
	<?php
	$ogg = asset('js/webcamjs/shutter.ogg');
	$mp3 = asset('js/webcamjs/shutter.mp3');
	?>
		<div class="py-0">
			<div style="display: block;" class="relative h-320 pt-1 flex-wrap align-items-center justify-content-center" id="camera">
				<i style="font-size: 3.5rem !important;" class="absolute left-32 top-20 align-items-center text-red-800 bi bi-camera"></i>
			</div>
			<div class="h-320 relative flex-wrap align-items-center rounded-xl justify-content-center" id="hasilGambar" >

			</div>
			<div class="py-1 flex-row gap-1 align-items-center justify-content-center">

			<input id="Start" class="w-full btn btn-sm btn-danger" type=button value="Start" onClick="configure()">

			<input id="snap" class="d-none w-full btn btn-sm btn-warning" type=button value="Capture" onClick="take_snapshot()">

				<input type="hidden" name="image" class="image-tag">
			</div>
		</div>
	</div>
</div>


<div class="col-span-2">

<div class="flex flex-row grid grid-cols-3 gap-2">

<div class="form-group">
    <?php
    $field_name = 'product_name';
    $field_lable = label_case('product_name');
    $field_placeholder = $field_lable;
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = "required";
    ?>
    <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
    <input class="form-control"
    type="text"
    name="{{ $field_name }}"
    id="{{ $field_name }}"
    value="{{old($field_name)}}"
    placeholder="{{ $field_placeholder }}">
    <span class="invalid feedback" role="alert">
        <span class="text-danger error-text {{ $field_name }}_err"></span>
    </span>
</div>

<div class="col-span-2">
<div class="flex flex-row gap-2">
   <div class="form-group w-40">
        <label for="group_id">@lang('Group') <span class="text-danger">*</span></label>
         <select class="form-control select2" name="group_id" id="group_id" required>
            <option value="" selected disabled>Group</option>
            @foreach(\Modules\Group\Models\Group::all() as $jp)
            <option value="{{ $jp->code }}">{{ $jp->name }}</option>
            @endforeach
        </select>
    </div>
<div class="form-group w-90">
    <label for="product_code">Code <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="text" id="code" class="form-control" name="product_code">
        <span class="input-group-btn">
            <button class="btn btn-info relative rounded-l-none" id="generate-code">Chek</button>
        </span>
    </div>
    <span class="invalid feedback" role="alert">
    <span class="text-danger error-text product_code_err"></span>
</span>
</div>
</div>


</div>


</div>

    @if(strpos($category->category_name, 'Mutiara') !== false)
    @include('product::products.modal.mutiara')

    @elseif(strpos($category->category_name, 'Berlian') !== false)
    @include('product::products.modal.berlian')

    @elseif (\Illuminate\Support\Str::contains($category->category_name, ['Perak', 'Paladium']))
    @include('product::products.modal.perak')

    @elseif(strpos($category->category_name, 'Logam Mulia') !== false)
    @include('product::products.modal.lm')

    @elseif (strpos($category->category_name, 'Emas') !== false)
    @include('product::products.modal.emas')

    @else
     @include('product::products.modal.all')
    @endif



   <div class="flex row px-3 py-0">
   {{-- ============================= --}}
                                    <div class="form-row">
                                        <div class="col-md-3">
								<div class="form-group">
									<?php
									$field_name = 'berat_emas';
									$field_lable = label_case('Berat');
									$field_placeholder = $field_lable;
									$invalid = $errors->has($field_name) ? ' is-invalid' : '';
									$required = "required";
									?>
									<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
									<input class="form-control"
									type="number"
									name="{{ $field_name }}"
									min="0" step="0.01"
									id="{{ $field_name }}"
									value="{{old($field_name)}}"
									placeholder="{{ $field_placeholder }}">
									<span class="invalid feedback" role="alert">
										<span class="text-danger error-text {{ $field_name }}_err"></span>
									</span>
								</div>

                                        </div>
                                        <div class="col-md-3">

				                      <div class="form-group">
											<?php
											$field_name = 'berat_accessories';
											$field_lable = label_case('berat_accessories');
											$field_placeholder = $field_lable;
											$invalid = $errors->has($field_name) ? ' is-invalid' : '';
											$required = "required";
											?>
											<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
											<input class="form-control"
											type="number"
											name="{{ $field_name }}"
											min="0" step="0.01"
											id="{{ $field_name }}"
											value="{{old($field_name)}}"
											placeholder="{{ $field_placeholder }}">
											<span class="invalid feedback" role="alert">
												<span class="text-danger error-text {{ $field_name }}_err"></span>
											</span>
										</div>


                                        </div>
                                        <div class="col-md-3">

				                      <div class="form-group">
											<?php
											$field_name = 'berat_label';
											$field_lable = label_case('berat_label');
											$field_placeholder = $field_lable;
											$invalid = $errors->has($field_name) ? ' is-invalid' : '';
											$required = "required";
											?>
											<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
											<input class="form-control"
											type="number"
											name="{{ $field_name }}"
											min="0" step="0.01"
											id="{{ $field_name }}"
											value="{{old($field_name)}}"
											placeholder="{{ $field_placeholder }}">
											<span class="invalid feedback" role="alert">
												<span class="text-danger error-text {{ $field_name }}_err"></span>
											</span>
										</div>


                                        </div>
                                        <div class="col-md-3">

		                                 <div class="form-group">
													<?php
													$field_name = 'berat_total';
													$field_lable = label_case('berat_total');
													$field_placeholder = $field_lable;
													$invalid = $errors->has($field_name) ? ' is-invalid' : '';
													$required = "required";
													?>
													<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
													<input class="form-control"
													type="number"
													name="{{ $field_name }}"
													min="0" step="0.01"
													id="{{ $field_name }}"
													value="{{old($field_name)}}"
													placeholder="{{ $field_placeholder }}">
													<span class="invalid feedback" role="alert">
														<span class="text-danger error-text {{ $field_name }}_err"></span>
													</span>
												</div>

                                        </div>
                                    </div>
 {{-- ======================================= --}}
                                </div>




 {{-- harga ========= --}}
            <div class="form-row">
                <div class="col-md-6">

				<div class="form-group">
					<?php
					$field_name = 'product_price';
					$field_lable = label_case($field_name);
					$field_placeholder = $field_lable;
					$invalid = $errors->has($field_name) ? ' is-invalid' : '';
					$required = "required";
					?>
					<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
					<input class="form-control"
					type="text"
					name="{{ $field_name }}"
					id="{{ $field_name }}"
					value="{{old($field_name)}}"
					placeholder="{{ $field_placeholder }}"
					>
					<span class="invalid feedback" role="alert">
						<span class="text-danger error-text {{ $field_name }}_err"></span>
					</span>
				</div>



                </div>
                <div class="col-md-6">

					<div class="form-group">
						<?php
						$field_name = 'product_cost';
						$field_lable = label_case($field_name);
						$field_placeholder = $field_lable;
						$invalid = $errors->has($field_name) ? ' is-invalid' : '';
						$required = "required";
						?>
						<label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
						<input class="form-control"
						type="text"
						name="{{ $field_name }}"
						id="{{ $field_name }}"
						value="{{old($field_name)}}"
						placeholder="{{ $field_placeholder }}"
						>
						<span class="invalid feedback" role="alert">
							<span class="text-danger error-text {{ $field_name }}_err"></span>
						</span>
					</div>

                </div>

            </div>
  {{-- ========= --}}





</div>








 </div>


  </form>
</div>

{{-- id="openModalKategori"
                href="{{ route('products.view_main_kategori_modal',$category->id)) }}" --}}



<script>
    jQuery.noConflict();
    (function( $ ) {

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
                        console.log(data.produk);
                        var value = data.produk;
                        Livewire.emit('addProduk', value);
                        $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                        $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                               $('#FormTambah').each(function(){
                            this.reset();
                        });

                          setTimeout(function () {
                              $('#ModalKategori').modal('hide');
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
            var Tombol = "<a href='{{ route('products.view_main_kategori_modal',$category->id) }}' id='BacktoKategori' class='btn btn-warning px-5'>{{ __('Back') }}</a>";
            Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanTambah'>{{ __('Create') }}</button>";
            $('#ModalFooterKategori').html(Tombol);
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


       $('#product_cost').maskMoney({
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

        $('#generate-code').click(function() {
            var group = $('#group_id').val();
            //alert(group);
            $(this).prop('disabled', true);
            $(this).addClass('loading');
            $.ajax({
                url: '{{ route('products.code_generate') }}',
                type: 'POST',
                data:{group:group},
                dataType: 'json',
                headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                       },
                 success: function(response) {
                    if (response.code === '0') {
                             $('#code').prop('readonly', true);
                             $('#code').val('Group harus di isi..!!');
                            } else {
                              $('#code').val(response.code);
                            }

                      console.log(response);

                    },
                complete: function() {
                    $('#generate-code').prop('disabled', false);
                    $('#generate-code').removeClass('loading');
                }
            });
        });




    })(jQuery);



</script>


<script language="JavaScript">
        function configure(){
            Webcam.set({
                width: 340,
                height: 230,
                autoplay: false,
                image_format: 'jpeg',
                jpeg_quality: 90,
                force_flash: false
            });
            Webcam.attach( '#camera' );
            $("#camera").attr("style", "display:block")
            $('#hasilGambar').addClass('d-none');
            $('#Start').addClass('d-none');
            $('#snap').removeClass('d-none');
        }
        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = false;
        shutter.src = navigator.userAgent.match(/Firefox/) ? asset('js/webcamjs/shutter.ogg') : asset('js/webcamjs/shutter.mp3');

        function take_snapshot() {
            // play sound effect
            shutter.play();
           // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                $(".image-tag").val(data_uri);
                $("#camera").attr("style", "display:none")
                $('#hasilGambar').removeClass('d-none').delay(5000);
                document.getElementById('hasilGambar').innerHTML =
                    '<img class="border-2 border-dashed border-yellow-600 rounded-xl" id="imageprev" src="'+data_uri+'"/><span class="absolute bottom-1 text-white right-4">Capture Sukses..!! </span>';
                $('#snap').addClass('d-none');
                $('#Start').removeClass('d-none');


            });
           Webcam.reset();
        }

        function reset() {
             Webcam.reset();
                 alert('off');
        }

        function saveSnap(){
            // Get base64 value from <img id='imageprev'> source
            var base64image =  document.getElementById("imageprev").src;

             Webcam.upload( base64image, 'upload.php', function(code, text) {
                 console.log('Save successfully');
                 //console.log(text);
            });

        }


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script type="text/javascript">
        $('input[type="radio"]').click(function () {
          var inputValue = $(this).attr("value");
          if (inputValue == "up2") {
            $("#webcam").hide();
             $("#upload").show();
          } else {
            $("#upload").hide();
             $('#webcam').removeClass('d-none');
            $("#webcam").show();
          }
        });
      </script>


