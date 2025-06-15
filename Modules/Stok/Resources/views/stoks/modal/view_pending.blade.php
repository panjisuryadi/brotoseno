  <div class="px-3">
 <div class="flex flex-row grid grid-cols-1 gap-4">
<table style="width:100%;" class="table table-borderlees">
  <tbody>


<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
      Cuci </label>
    </td>
    <td class="w-50">
          <div class="form-group font-semibold text-lg">
           {{$detail->weight}}
        </div>
    </td>
</tr>

<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
      rongsok </label>
    </td>
    <td class="w-50">
        <div class="form-group font-semibold text-lg">
             {{$detail->weight}}
        </div>
    </td>
</tr>

<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
      olah kembali </label>
    </td>
    <td class="w-50">
        <div class="form-group font-semibold text-lg">
             {{$detail->weight}}
        </div>
    </td>
</tr>

<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
      total </label>
    </td>
    <td class="w-50">
          <div class="form-group font-semibold text-lg">
             {{$detail->weight}}
        </div>
    </td>
</tr>


  </tbody>
</table>
</div>

 

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
    Tombol += "<button type='button' class='px-5 btn btn-outline-success' id='SimpanUpdate'>{{ __('Cetak') }}</button>";
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