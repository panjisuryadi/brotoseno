<div class="px-3">
      <x-library.alert />
      <form id="FormEdit" action="{{ route('karat.update_diskon', $detail) }}" method="POST">
          @csrf
          @method('patch')
          <div class="flex flex-row grid grid-cols-1 gap-4">
              
              <div class="form-group">
                  <?php
                    $field_name = 'diskon';
                    $field_lable = label_case('Max Diskon');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    ?>
                  <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                  <input type="hidden" name="id" value="{{$detail->id}}">
                  <input class="form-control" type="number" name="{{ $field_name }}" step="0.01" id="{{ $field_name }}" value="{{$detail->diskon }}">
              </div>
          </div>
      </form>
  </div>
  <script>
      jQuery.noConflict();
      (function($) {

          function autoRefresh() {
              var table = $('#datatable').DataTable();
              table.ajax.reload();

          }

          function Update() {
              $.ajax({
                  url: $('#FormEdit').attr('action'),
                  type: "POST",
                  cache: false,
                  data: $('#FormEdit').serialize(),
                  dataType: 'json',
                  success: function(data) {
                    location.reload();  
                      console.log(data.error)
                      if ($.isEmptyObject(data.error)) {
                          $('#ResponseInput').html(data.success);
                          $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                          $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                          setTimeout(function() {
                              autoRefresh();
                          }, 1000);
                          setTimeout(function() {
                              $('#ModalGue').modal('hide');
                          }, 3000);

                      } else {
                          printErrorMsg(data.error);
                      }
                  }
              });
          }

          function printErrorMsg(msg) {
              $.each(msg, function(key, value) {
                  console.log(key);
                  $('#' + key + '').addClass("");
                  $('#' + key + '').addClass("is-invalid");
                  $('.' + key + '_err').text(value);

              });
          }
          $(document).ready(function() {

              var Tombol = "<button type='button' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
              Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanUpdate'>{{ __('Update') }}</button>";
              $('#ModalFooter').html(Tombol);

              $("#FormEdit").find('input[type=text],textarea,select').filter(':visible:first').focus();

              $('#SimpanUpdate').click(function(e) {
                  e.preventDefault();
                  Update();
              });

              $('#FormEdit').submit(function(e) {
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