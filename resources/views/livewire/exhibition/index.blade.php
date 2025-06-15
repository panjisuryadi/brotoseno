
    <div>
        @if (session()->has('message'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="alert-body">
                <span>{{ session('message') }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
        @endif
        <div style="height: 500px !important;" class="table-responsive position-relative relative h-full">
            <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

<!-- component -->

  <div class="grid grid-cols-12 gap-2 gap-y-4 max-w-6xl">

    <!-- Video 4 -->

   @if($cart_items->isNotEmpty())
                    @foreach($cart_items as $cart_item)



    <div class="col-span-12 sm:col-span-6 md:col-span-3 rounded-lg border-2">
      <card class="w-full flex flex-col">
        <div class="relative">

          <!-- Image Video -->
          <a href="#">
            <img src="{{ url('images/fallback_product_image.png') }}" class="w-96 h-auto" />
          </a>

          <div class="absolute right-2 bottom-2">

             @include('livewire.includes.product-detail-modal')
          </div>
        </div>

    <div class="px-2 flex-1 px-1 mt-2 min-w-0">


                                <p class="text-md font-medium text-gray-900 truncate dark:text-white">
                                    {{ $cart_item->name }}
                                </p>
                             
     </div>


<div class="flex px-2 mb-2 justify-between">
  <div> {{ $cart_item->options->code }}</div>
<div class="text-xs text-gray-500 truncate">
    <a href="#" class="bg-red-500 text-white rounded rounded-lg px-3" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')">
   Hapus
</a>  
</div>
  
</div>

      </card>
    </div>

  @endforeach
                    @else
                    <div class="w-ful txt-base flex-row py-2 px-2  text-danger">
                     {{--    @lang('Please search & select products!') --}}
                    </div>
                    @endif


  </div>

            @php
            $hitung = Cart::instance($cart_instance)->count()
            @endphp
            <div class="absolute top-1 right-2 px-2 flex flex-row justify-between">
                <div></div>
                <div class="text-center">
                    <p class="text-5xl font-bold"> {{ $hitung }}</p>
                    <p class="text-xxsm text-gray-400">Total.</p>
                </div>
            </div>
        </div>
    </div>
