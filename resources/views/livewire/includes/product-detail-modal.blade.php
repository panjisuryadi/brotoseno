<!-- Button trigger Modal -->
<button role="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#detailProduk{{ $cart_item->id }}">
    <i class="small p-1 bi bi-search text-white"></i>
</button>
<!--  Modal -->
<div wire:ignore.self class="modal fade" id="detailProduk{{ $cart_item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="discountModalLabel">
                    {{ $cart_item->name }}
                    
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <div class="modal-body px-3 py-2" id="ModalContentDetail">
     
<div class="flex w-full flex-row  gap-1 py-2">
   <div class="w-1/4">

<div class="p-0 object-center">
<?php

      if ($cart_item->options->images) {
            $logo = asset("storage/uploads/" .$cart_item->options->images);
        }else{
            $logo = asset('images/fallback_product_image.png');
        }

?>
 <img src="{{ $logo }}" alt="background" class="rounded-xl h-auto bg-cover mx-auto">
 </div>
   </div>


   <div class="w-3/4">

          <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Product Code
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                   {{ $cart_item->options->code }}
                </dd>
            </div> 

            <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Karat
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                   {{ $cart_item->options->karat }}
                </dd>
            </div>
     <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Berat Emas
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                      {{ $cart_item->options->berat_emas }} <small>Gram</small>
                </dd>
            </div>



      <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Harga Jual
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
               {{ format_uang($cart_item->options->harga_jual) }}
                </dd>
            </div>

             <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                   Harga Total
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                 {{ format_uang($cart_item->price) }}
                </dd>
            </div>


   </div>

</div>


           </div>
           <div class="modal-footer" id="ModalFooterDetail">
               
<button type="button" class="px-3 btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="submit" class="btn btn-primary">Save changes</button> --}}


           </div>
        </div>
    </div>
</div>
