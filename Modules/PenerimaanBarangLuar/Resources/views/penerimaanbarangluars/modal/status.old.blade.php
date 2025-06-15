  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.update_status', $detail) }}" method="POST">
                            @csrf
                            @method('patch')
             <div class="flex flex-row grid grid-cols-1 gap-4">
            
             
        <div class="form-group">
                    <label for="status_id">Status <span class="text-danger">*</span></label>
                    <select class="form-control uppercase" name="status_id" id="status_id" required>

   <option value="" {{ is_null($detail->current_status) ? 'selected' : ''}} disabled>PENDING</option>

  @foreach($proses_statuses as $status)
    <option value="{{$status->id}}" class="uppercase">
        {{ $status->name }}
    </option>
  @endforeach


      </select>
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

    var Tombol = "<button type='button' class='btn btn-outline-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
    Tombol += "<button type='button' class='px-5 btn btn-outline-success' id='SimpanUpdate'>{{ __('Update') }}</button>";
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