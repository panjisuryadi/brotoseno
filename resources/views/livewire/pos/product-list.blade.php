<div >
    <div class="card border-0 py-0">
        <div class="card-body px-3 py-1">
<livewire:pos.filter :categories="$categories"/>

                <div class="mt-2 grid grid-cols-4 md:gap-0 lg:gap-1 gap-2 md:grid-cols-4 sm:grid-cols-2 lg:grid-cols-4 relative">
                    <div wire:loading.flex class="position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>


                    @forelse($products as $product)
                          {{-- {{ $product->product_price }} --}}



                    <div wire:click.prevent="selectProduct({{ $product }})" class="md:px-1 py-1" style="cursor: pointer;">

                        @php
                                $image = $product?->images;
                                $imagePath = '';
                                if(empty($image)){
                                    $imagePath = url('images/fallback_product_image.png');
                                }else{
                                    $imagePath = asset(imageUrl().$image);
                                }
                        @endphp
                        <div
                            class="h-40 lg:h-32 md:h-32 relative overflow-hidden rounded-md  hover:shadow-md"
                            >
                            <img
                            src="{{ $imagePath }}"
                            class="absolute inset-0 h-full w-full object-cover"
                            />

                            <span style="font-size:0.7rem;" 
                                class="absolute top-2 leading-5 left-1 inline-flex items-center justify-center rounded-lg bg-red-400 px-1 py-0.2 text-red-200"
                                >
                               {{@$product->karat->label}}
                            </span>
                            <div
                                class="absolute md:bottom-1 bottom-3 md:leading-4 left-2"
                                >

                                <div class="px-1 sm:p-4 md:mt-4 lg:p-2">
                                    <span  class="md:text-xs md:leading-4 block text-gray-600">
                                     {{ @$product->category->category_name }} 
                                    </span>
                                    
                                    <h3 class="leading-5 font-semibold hover:text-red-400 mt-0.5 lg:text-sm sm:small md:text-sm md:leading-3 md:leading-4 text-lg text-gray-800">
                                    {{ $product->product_name }}
                                    </h3>
                                <div class="lg:text-sm md:small text-red-400">
                                    <small>Rp .</small>

                                   @if($product->product_price) 
                                    {{ @rupiah($product->product_price) }}
                                    @else
                                    {{@rupiah($product->karat->penentuanHarga->harga_jual*$product->berat_emas)}}
                                   @endif        


                                 </div>

    
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="mt-1 flex flex-row col-span-4">
                        <div class="w-full px-3 py-2  alert alert-warning mb-0">
                            Produk Tidak Ditemukan ...!!
                        </div>
                    </div>
                    @endforelse
                </div>
                <div @class(['mt-3' => $products->hasPages()])>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>