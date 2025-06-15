
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

  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.rfid_update', $product) }}" method="POST">
                            @csrf
                            @method('patch')


          <div class="form-group">
            {{ $code }}
                                <?php
                                $field_name = 'rfid';
                                $field_lable = label_case('rfid');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>

                        <input class="form-control rounded rounded-lg sortir text-center" type="text"
                        name="{{ $field_name }}" placeholder="RFID" autofocus>
                                <span class="invalid feedback" role="alert">
                                    <span class="upper text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>

             <div class="flex flex-row grid grid-cols-2 gap-4" >

 <div class="form-group">
                         @forelse($product->getMedia('images') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Product Image" class="h-100 img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="Product Image" class="img-fluid img-thumbnail mb-2 h-100">
                        @endforelse
</div>





                        <div class="w-100 form-group">

                                  <table class="w-100 table table-bordered table-striped mb-0">
                                <tr>
                                    <th>Product Code</th>
                                    <td>{{ $product->product_code }}</td>
                                </tr>
                                <tr>
                                    <th>Barcode Symbology</th>
                                    <td>{{ $product->product_barcode_symbology }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $product->product_name }}</td>
                                </tr>

                                <tr>
                                    <th>Cost</th>
                                    <td>{{ format_currency($product->product_cost) }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{ format_currency($product->product_price) }}</td>
                                </tr>


                            </table>

                            </div>


 {{--          <div class="card-body text-center">
                        <div class="py-2 d-flex flex-wrap align-items-center justify-content-center">
                     {!! \Milon\Barcode\Facades\DNS1DFacade::getBarCodeSVG($product->product_code, $product->product_barcode_symbology, 2, 110) !!}
                    </div>
                        @forelse($product->getMedia('images') as $media)
                            <img src="{{ $media->getUrl() }}" alt="Product Image" class="img-fluid img-thumbnail mb-2">
                        @empty
                            <img src="{{ $product->getFirstMediaUrl('images') }}" alt="Product Image" class="img-fluid img-thumbnail mb-2">
                        @endforelse
                    </div> --}}



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




