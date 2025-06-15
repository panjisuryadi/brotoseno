<div>
    <div class="card border-0 shadow-sm mt-0">
        <div class="card-body pt-1">
 <div wire:loading.flex class="col-12 justify-content-center align-items-center">
                    <div class="spinner-border text-primary text-center" role="status">
                        <span class="sr-only  text-center">Loading...</span>
                    </div>
                </div>
                @forelse($products as $product)
                    <div wire:click.prevent="selectProduct({{ $product }})" class="d-flex col-12" style="cursor: pointer;">

        <div class="row border-bottom mt-1 mb-2">
        <div class="col-md-2 p-0">
            <img src="{{ $product->getFirstMediaUrl('images') }}" class="w-100 rounded">
          </div>
          <div class="col-md-8 px-3">
            <div class="card-block px-0">
              <h5 class="card-title mt-1 mb-0">{{ $product->product_name }}</h5>
              <div class="card-text mb-0">{{ format_currency($product->product_price) }}</div>
              <span class="badge badge-success mb-0">Stock: {{ $product->product_quantity }}</span>
            </div>
          </div>

        </div>

                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                           @lang('No Product Found') ...
                        </div>
                    </div>
                @endforelse

          {{--   <div @class(['mt-3' => $products->hasPages()])>
                {{ $products->links() }}
            </div> --}}
        </div>
    </div>
</div>
