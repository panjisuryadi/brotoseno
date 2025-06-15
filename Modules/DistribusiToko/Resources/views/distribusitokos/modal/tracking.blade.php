<!-- component -->
<div class="bg-white px-4 overflow-hidden py-2">

<div class="flex justify-between px-1 py-3 border px-4 rounded">
    <div class="text-gray-600">
        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
        <div>Tanggal: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
    </div>
    <div class="text-gray-600">
        <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
        <div>
            Dibuat oleh: <strong>{{ $dist_toko->created_by }}</strong>
        </div>
    </div>
    
</div>

<div class="w-full  mx-auto relative py-0">
 
      <div class="border-l-2 mt-2">
        <!-- Card 1 -->
        <div class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-2 bg-blue-300 text-white rounded mb-3 flex-col md:flex-row space-y-4 md:space-y-0">
          <!-- Dot Follwing the Left Vertical Line -->
          <div class="w-5 h-5 bg-blue-300 absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>
          <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0"></div>
           <div class="justify-self-stretch gap-3">
            <div style="font-size: 0.7rem;" class="text-left text-gray-900">{{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</div>
            <div class="font-normal text-left leading-5 text-gray-800">
            Barang di Approve oleh: Kepala Cabang 
           </div>

          </div>
         
        </div>

  <div class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-2 bg-green-400 text-white rounded mb-3 flex-col md:flex-row space-y-4 md:space-y-0">
          <!-- Dot Follwing the Left Vertical Line -->
          <div class="w-5 h-5 bg-green-400 absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>
          <div class="w-10 h-1 bg-green-500 absolute -left-10 z-0"></div>
             <div class="justify-self-stretch gap-3">
            <div style="font-size: 0.7rem;" class="text-left text-gray-600">
              {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}  
            </div>
            <div class="font-normal text-left leading-5 text-gray-800">
            Barang di Approve oleh: Manager 
           </div>

          </div>
         
        </div>



      </div>
   
    </div>

</div>
</div>



<script>
jQuery.noConflict();
(function( $ ) {
    $(document).ready(function(){
        var Tombol = "<button type='button' class='btn btn-outline-success px-8' data-dismiss='modal'>{{ __('Close') }}</button>";
       
        $('#ModalFooter').html(Tombol);
      });
})(jQuery);
</script>