  <div class="px-3">
  <x-library.alert />
<form id="FormEdit" action="{{ route('products.transfer.approvebarang', $detail->id) }}" method="POST">
	@csrf
	@method('patch')


	<div class="flex flex-row grid grid-cols-1 gap-4">
		<div class="flex px-3 items-center py-2 rounded rounded-lg border border-gray-500">
			<img class="w-10 h-10 rounded-full mr-2" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Avatar of Writer">
			<div class="text-sm">
				<p class="text-gray-900 leading-none">{{ auth()->user()->name }}</p>
				<p class="text-gray-600 font-semibold">{{ auth()->user()->roles->pluck("name")->first(); }}</p>
			</div>
		</div>
		<div class="form-group mb-0">
			<?php
			$field_name = 'status';
			$field_lable = label_case('Status');
			$field_placeholder = $field_lable;
			$invalid = $errors->has($field_name) ? ' is-invalid' : '';
			$required = "required";
			?>
			<label class="mb-0" for="{{ $field_name }}">@lang('Status') <span class="text-danger">*</span></label>
			<select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" required>
				<option value="" selected disabled>@lang('Status')</option>
				<option value="3">Approved</option>
				<option value="4">Reject</option>
			</select>
			<div class="invalid feedback" role="alert">
				<span class="text-danger error-text {{ $field_name }}_err"></span>
			</div>
		</div>
{{--
	<div class="form-group mb-0">
        @php
        $locations = \Modules\Locations\Entities\Locations::where('name','LIKE','%Utama%')->get();
        @endphp


        <label class="mb-0" for="">Lokasi</label>
        <select name="location_id" class="form-control select2">
            @foreach ($locations as $loc)
            <option value="{{ $loc->id }}" selected>{{ $loc->name }}</option>
            @endforeach
        </select>
    </div>  --}}
		<div class="form-group mb-2">
			<label class="mb-0" for="status">@lang('Note') <span class="text-danger">(Optional)</span></label>
			<textarea name="note" id="note" rows="2" class="form-control"></textarea>
		</div>
	</div>
</form>


</div>

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
    Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanUpdate'>{{ __('Approve') }}</button>";
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