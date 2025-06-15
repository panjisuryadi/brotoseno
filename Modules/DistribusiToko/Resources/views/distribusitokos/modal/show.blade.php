<div class="bg-white overflow-hidden py-2">

<div class="px-4 py-2 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
         {{ tanggal($detail->date)}}
        </h3>
      
     <p class="mt-1 max-w-xl text-sm text-gray-500">
           Dibuat Oleh :  {{ @$detail->created_by}}
        </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-2 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">

            <div class="py-3 sm:py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Cabang
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
               {{ @$detail->cabang->code}} | {{ @$detail->cabang->name}}
                </dd>
            </div>     

           

            <div class="py-3 sm:py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Berat
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      <span class="font-semibold border border-2 border-blue-800 rounded-md px-2 text-lg text-blue-800 py-0.`">
                           {{ @$detail->weight ?? '0'}}
                    </span>
                </dd>
            </div
      
        </dl>
    </div>




</div>

<script>
jQuery.noConflict();
(function( $ ) {

 
   


$(document).ready(function(){

    var Tombol = "<button type='button' class='btn btn-outline-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
    Tombol += "<button type='button' class='px-5 btn btn-outline-success' id='Cetak'>{{ __('Print') }}</button>";
    $('#ModalFooter').html(Tombol);

    $('#Cetak').click(function(e){
           CetakStruk();
           // setTimeout(function(){ 
           //   location.reload();               
           //   }, 3000);
    });


function CetakStruk()
{
    window.open("{{ route(''.$module_name.'.cetak', encode_id($detail->id)) }}");
    
}
  

});
})(jQuery);
</script>