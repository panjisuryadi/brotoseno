
<style type="text/css">

.sortir {
    border: 0.2rem solid;
    color: #111827;
    font-size: 1.4rem;
    font-weight: 600;
    letter-spacing: 0.1rem;
    background-color: #f0f0f0;
    border-style: dashed;
    height: 5rem;
}


.sortir:focus {
  background-color: #fbe5e5;
}

</style>

<div class="w-full flex flex-row p-2">
  <x-library.alert />    

</div>


  <form class="px-3" id="FormEdit" action="{{ route(''.$module_name.'.sortir_update', $product) }}" method="POST">
                            @csrf
                            @method('patch')
<div class="flex flex-row grid grid-cols-1 gap-4">
<div class="flex px-3 items-center py-2 rounded rounded-lg border border-gray-500">
            <img class="w-20 h-20 rounded-full mr-2" src="{{ $product->getFirstMediaUrl('images') }}" alt="Avatar of Writer">
            <div class="text-sm">
                <p class="text-lg text-gray-900 font-semibold leading-none">{{ $product->product_name }}</p>
                <p class="text-gray-400 font-semibold">{{ $product->product_code }}</p>
                <p class="text-gray-600">{{ format_currency($product->product_cost) }}</p>
                <p class="text-gray-600">{!!statusTrackingProduk($product->status) !!}</p>
            </div>
        </div>




    <div class="form-group mb-0">
                    @php
         $sortir = \Modules\Locations\Entities\Locations::where('name','LIKE','%Pusat%')
         ->first();
         $bb = \Modules\Locations\Entities\Locations::where('parent_id',$sortir->id)
         ->where('name', 'NOT LIKE', '%Sortir%')->get();
                     @endphp
                        <label class="mb-0" for="location_id">Lokasi</label>
                        <select name="location_id" class="form-control select2">
                            @foreach ($bb as $b)
                            <option value="{{ $b->id }}" selected>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>




    <div class="form-group mb-2">
            <label class="mb-0" for="status">@lang('Note') <span class="text-danger">(Optional)</span></label>
            <textarea name="note" id="note" rows="2" class="form-control"></textarea>
        </div>

</div>
 </form>

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

    var Tombol = "<button type='button' class='btn btn-secondary px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
    Tombol += "<button type='button' class='px-5 btn btn-success' id='SimpanUpdate'>{{ __('Update') }}</button>";
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

   setTimeout(function() { $('input[name="rfid"]').focus() }, 1000);
      $('#rfid').on('input', function() {
          var kolom = $(this).val();
          var rfid = kolom.length;
           if (rfid > 5) {
                  $('#SimpanUpdate').click();
                }
        });

    });
})(jQuery);
</script>




