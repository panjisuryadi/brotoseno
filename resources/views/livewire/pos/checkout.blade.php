<div>
        <div class="mt-1">
           



                @if (session()->has('message'))
                <div class="px-3">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <span>{{ session('message') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                    </div>
                @endif

<div class="px-3">

            <input id="customer_id" wire:model="customer_id" type="hidden" name="customer_id">



              {{--   <div class="form-group">
                    <label for="customer_id">Customer <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="{{ route('customers.create') }}" class="btn bg-red-400">
                                <i class="text-white bi bi-person-plus"></i>
                            </a>
                        </div>
                        <select wire:model="customer_id" id="customer_id" class="select2 form-control">
                            <option value="" selected>Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                <div style="height: 440px;" class="overflow-y-auto max-h-full md:max-h-screen">
              
                        @if($cart_items->isNotEmpty())
                        @php 
                          $jumlah = 0; 
                        @endphp
                            @foreach($cart_items as $cart_item)
                 {{-- {{dd($cart_item)}} --}}
                   <!-- component -->
                      <div class="bg-white text-white w-full max-w-lg flex flex-col border-b rounded-md p-1">
                        <div class="flex items-center justify-between">
                          <div class="flex items-center space-x-4">
                            <div class="rounded-full w-4 h-4 border border-blue-500"></div>
                            <div class="text-md text-dark font-bold">
                               <div class="text-lg relative">{{ $cart_item->name }}
                                @include('livewire.includes.product-detail-modal') 
                               </div>
                     <div style="font-size: 0.6rem;" class="text-gray-400">#{{ $cart_item->options->code }} | 
                        <span class="text-yellow-500">
                            {{ $cart_item->options->karat }}
                        
                        </span>|
                        <span class="text-blue-400">
                            {{ format_uang($cart_item->price) }}
                        </span>
                      
                       </div>
                             </div>
                          </div>
                          <div class="flex items-center space-x-4">
                            <div class="text-gray-500 hover:text-gray-300 cursor-pointer">
                             <a href="#" wire:loading.class="opacity-50" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')">
                             <i class="bi bi-x-circle font-xl text-danger"></i>
                                </a>
                            </div>
                          </div>
                        </div>
                        
                      </div>
 
                          @php
                             $jumlah = $jumlah +  $cart_item->qty
                          @endphp

                            @endforeach
                          @else
                          
                        <span class="flex text-center text-danger py-2">
                           Produk Belum di pilih
                        </span>
                            
                        @endif
                    
                </div>























          {{-- <div style="height: 440px;" class="overflow-y-auto max-h-full md:max-h-screen">
            @if($customs->isNotEmpty())
            @php 
              $jumlah = 0; 
            @endphp
              @foreach($customs as $custom)

                <div class="bg-white text-white w-full max-w-lg flex flex-col border-b rounded-md p-1">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                      <div class="text-md text-dark font-bold">
                         <div class="text-lg relative">{{ $custom->jenis_barang }}
                         </div>
                      <div style="font-size: 0.6rem;" class="text-gray-400">#{{ $custom->harga }}
                        <span class="text-yellow-500">
                            {{ $custom->jenis_barang }}
                        </span>|
                        <span class="text-blue-400">
                            {{ format_uang($custom->total) }}
                        </span>
                      </div>
                       </div>
                    </div>
                      <div class="flex items-center space-x-4">
                        <div class="text-gray-500 hover:text-gray-300 cursor-pointer">
                          <a href="#" wire:loading.class="opacity-50" wire:click.prevent="removeCustome('{{ $custom->id }}')">
                            <i class="bi bi-x-circle font-xl text-danger"></i>
                          </a>
                        </div>
                      </div>
                  </div>
                </div>

              @endforeach
            @else
                    
            <span class="flex text-center text-danger py-2">
                Tidak memiliki custome produk
            </span>
            @endif
          </div> --}}


















                

<div class="flex flex-row justify-between gap-1 py-2">

  <div class="px-1 text-center justify-items-center">
    <button wire:loading.class="text-gray-200" wire:click="resetCart" type="button" class="flex flex-row hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center">
      <i class="hover:text-red-400 text-2xl text-gray-500 bi bi-trash"></i>
      <div class="mb-1 ml-1 lg:text-sm md:text-sm text-xl py-0 font-semibold">Hapus</div>
    </button>
  </div>
  <div class="px-1 text-center justify-items-center">
    <button wire:loading.class="text-gray-200" wire:click="showCustom" type="button" class="flex flex-row hover:no-underline hover:text-blue-400 text-gray-500 px-3 text-center items-center">
      <i class="hover:text-blue-400 text-2xl text-gray-500 bi bi-file-plus"></i>
      <div class="mb-1 ml-1 lg:text-sm md:text-sm text-xl py-0 font-semibold">Custom</div>
    </button>
  </div>


{{-- <div class="relative items-center hover:text-gray-300 justify-center text-center md:text-xl">
  <button wire:loading.attr="disabled" wire:click="proceed" type="button" class="flex flex-row hover:no-underline hover:text-gray-300 text-white text-2xl font-semibold text-center items-center">Bayar
   </button>
</div> --}}








{{-- <div class="px-1 text-center justify-items-center">
   <button wire:loading.attr="disabled" wire:click.prevent="proceed" type="button" class="flex flex-row hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center">
   <i class="hover:text-red-400 text-xl text-gray-500 bi bi-save"></i>
  <div class="mb-1 ml-1 lg:text-sm md:text-sm text-xl py-0 font-semibold">Simpan</div>
</button>
</div> --}}



</div>
</div>





{{-- batassss --}}
@if($cart_items->isNotEmpty())
 @if($cart_items->first()->options->manual)
 <div class="px-3 py-2 flex justify-between border border-gray-300 rounded-md">
  <div class="font-semibold text-gray-500">
   {{ $cart_items->first()->options->manual_item }}

  </div>
   <div class="font-semibold text-gray-500">
   {{ format_currency($cart_items->first()->options->manual_price) }}
  </div>

</div>
   @endif
@endif


{{-- batassss --}}

<div class="w-full px-3 py-3 bg-red-400 text-white flex justify-between">
   <div class="flex flex-row w-40 justify-items-center items-center text-center border-r">
{{--  <div class="relative items-center justify-center text-center md:text-xl text-white text-3xl font-semibold">
          {{$jumlah ?? '0'}}
        </div> --}}
        <div class="md:text-xl text-white text-2xl font-semibold relative p-3">
          <i class="bi bi-cart-fill"></i>
            <span class="absolute top-2 right-1 inline-flex items-center justify-center w-6 h-6 ml-2 text-xs font-semibold text-dark bg-yellow-300 rounded-full">
                 {{$jumlah ?? '0'}}
              </span>
        </div>
        <div class="relative items-center hover:text-gray-300 justify-center text-center md:text-xl">
            <button wire:loading.attr="disabled" wire:click="proceed" type="button" class="flex flex-row hover:no-underline hover:text-gray-300 text-white text-2xl font-semibold text-center items-center">Bayar
             </button>
        </div>





    </div>  

<div class="w-60 justify-end flex text-center items-center">
  <span class="md:text-base lg:text-xl text-xl font-semibold">{{ format_uang(!empty($this->total_amount) ? $this->total_amount : 0) }}</span>
    <i class="ml-3 text-2xl bi bi-chevron-right"></i>
  </div>
</div>


</div>

    {{-- @include('livewire.pos.includes.payment-modal') --}}

    {{--Checkout Modal--}}

    @include('sale::pos.custom-modal')
    @include('sale::pos.checkout-modal')
  </div>

