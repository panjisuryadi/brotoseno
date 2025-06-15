  <div class="px-3">
  <x-library.alert />
  
  <livewire:karat.create />


</div>

{{-- <script src="{{ asset('js/jquery-mask-money.js') }}"></script> --}}
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


});
})(jQuery);
</script>