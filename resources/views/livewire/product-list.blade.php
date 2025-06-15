<div>
    <div class="card border-0 shadow-sm mt-3">
        <div class="px-3 card-body">
            <livewire:pos.filter :categories="$categories"/>
            <div class="row position-relative">
                <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                @forelse($products as $product)

                    <div wire:click.prevent="selectProduct({{ $product }})" class="col-lg-3 col-md-6 lg:col-lg-2 col-md-6" style="cursor: pointer;">
                        <div class="card border-0 shadow h-100">
                            <div class="position-relative">
                                <img height="200" src="{{ $product->getFirstMediaUrl('images') }}" class="card-img-top" alt="Product Image">
                                <div class="badge badge-info mb-3 position-absolute" style="left:10px;top: 10px;">Stock: {{ $product->product_quantity }}</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <h6 style="font-size: 13px;" class="card-title mb-0">{{ $product->product_name }}</h6>
                                    <span class="badge badge-success">
                                    {{ $product->product_code }}
                                </span>
                                </div>


              
     <p class="card-text font-weight-bold">{{ rupiah($product->product_price) }}</p>
      
                            </div>
                        </div>
                    </div>
                @empty
                        <div class="alert flex items-center alert-warning mb-0">
                            @lang('No Product Found')
                        </div>
                    </div>
                @endforelse
            </div>
            <div @class(['mt-3 flex items-center' => $products->hasPages()])>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
