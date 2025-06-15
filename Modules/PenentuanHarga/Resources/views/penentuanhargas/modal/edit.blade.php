  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.update', $detail) }}" method="POST">
<div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400"> History Penentuan Harga
                                </span>

                        </span></div>
                    </div>

<table class="w-full mb-2">
            @if($history)
            <tr>
                <td>Karat</td>
                <td>
                    <span class="text-lg font-semibold">
                        {{@$detail->karat->label }}</span>
                </td>
            </tr> 

            <tr>
                <td>Terakhir Update</td>
                <td>
                    {{ tgl($history->tanggal) }}
                </td>
            </tr>
            <tr>
                <td>Jumlah di Update</td>
                <td>
                    {{ $detail->history->count() }} kali
                </td>
            </tr>  

             <tr>
                <td>Harga Jual</td>
                <td>
                    {{ rupiah($detail->harga_jual) }}
                </td>
            </tr>


             <tr>
                <td>Harga Modal</td>
                <td>
                    {{ rupiah($detail->harga_modal) }}
                </td>
            </tr>
            @else
            <div>Data belum ada</div>
            @endif
        </table>


    <div class="px-0 flex justify-between py-2 border-bottom">
    

<table style="width: 100%;" class="table table-striped table-bordered">
    <tr>
        <th style="width:5%;" class="text-center">{{ label_case('No') }}</th>
        
        <th class="text-center">{{ label_case('Tanggal') }}</th>
        <th class="text-center">{{ label_case('Harga Jual') }}</th>
        <th class="text-center">{{ label_case('Harga Modal') }}</th>
        <th class="text-center">{{ label_case('Harga Emas') }}</th>
        <th class="text-center">{{ label_case('margin') }}</th>
        <th class="text-center">{{ label_case('Admin') }}</th>
        <th class="text-center">{{ label_case('Status') }}</th>
    </tr>
    @forelse(\Modules\PenentuanHarga\Models\HistoryPenentuanHarga::where('penentuan_harga_id',$detail->id)->latest()->get() as $sale)
    
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td class="text-center text-blue-400">{{ tgl($sale->tanggal) }}</td>
        <td class="text-center"> {{ rupiah($sale->harga_jual) }}</td>
        <td class="text-center"> {{ rupiah($sale->harga_modal) }}</td>
        <td class="text-center"> {{ rupiah($sale->harga_emas) }}</td>
        <td class="text-center"> {{ rupiah($sale->margin) }}</td>
        <td class="text-center">{{ $sale->created_by }}</td>
        <td class="text-center">
@if($sale->updated == 1)
<span class="rounded text-white bg-red-500 px-3"><i class="bi bi-lock-fill"></i> Locked</span>
@else
<span class="rounded text-white  bg-blue-400 px-3"><i class="bi bi-unlock"></i> Unlocked</span>
@endif

        </td>
        
        
        
        
    </tr>
    @empty
    <tr>
        <td colspan="8"> <p class="uppercase">Tidak ada Data</p></td>
        
    </tr>
    @endforelse
    
</table>






        
    </div>




  
                            @csrf
                            @method('patch')
             <div class="flex flex-row grid grid-cols-2 gap-4 mt-3">
                            <div class="form-group">
                                <?php
                                $field_name = 'harga_emas';
                                $field_lable = label_case('harga_emas');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" 
                        type="text"
                        name="{{ $field_name }}"
                        id="{{ $field_name }}"
                        type-currency="IDR"
                                    value="{{$detail->harga_emas }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>

                        <div class="form-group">
                                <?php
                                $field_name = 'margin';
                                $field_lable = label_case('margin');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" type="text"
                        name="{{ $field_name }}"
                        id="{{ $field_name }}"
                        type-currency="IDR"
                        value="{{$detail->margin }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>
</div>


            </form>


</div>
{{-- <script src="{{ asset('js/jquery-mask-money.js') }}"></script> --}}


<style type="text/css">
.table th, .table td {
    padding: 0.45rem !important;
    vertical-align: top;
    border-top: 1px solid;
    border-top-color: #d8dbe0;
}

</style>

<script>
jQuery.noConflict();
(function( $ ) {


  function reloadTable(){
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
                      location.reload()
                      //function below is deprecated
                    //   setTimeout(function(){ reloadTable(); }, 1000);
                    //   setTimeout(function () {
                    //           $('#ModalGue').modal('hide');
                    //         }, 3000);

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


   
document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
        element.addEventListener('keyup', function(e) {
            let cursorPostion = this.selectionStart;
            let value = parseInt(this.value.replace(/[^,\d]/g, ''));
            let originalLenght = this.value.length;
            if (isNaN(value)) {
                this.value = "";
            } else {
                this.value = value.toLocaleString('id-ID', {
                    currency: 'IDR',
                    style: 'currency',
                    minimumFractionDigits: 0
                });
                cursorPostion = this.value.length - originalLenght + cursorPostion;
                this.setSelectionRange(cursorPostion, cursorPostion);
            }
        });
    });




$(document).ready(function(){

    var Tombol = "<button type='button' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
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
});
})(jQuery);
</script>