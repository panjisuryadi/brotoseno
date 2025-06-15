<div class="position-relative">
<div class="form-group">
    <label class="mb-0">Cari Produk</label>
    <div class="w-full flex border-2 rounded">
        <input style="width: 90%;" wire:keydown.escape="resetQuery" wire:model.debounce.500ms="query" type="text" class="px-2 py-2" placeholder="Cari Produk">
        <button class="flex items-center justify-center px-0">
        <svg class="w-6 h-6 text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24">
            <path
                d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z" />
            </svg>
            </button>
        </div>
    </div>


<div wire:loading class="card position-absolute mt-1 border-0" style="z-index: 1;left: 0;right: 0;">
<div class="card-body shadow">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
</div>

    @if(!empty($query))
        <div wire:click="resetQuery" class="position-fixed w-100 h-100" style="left: 0; top: 0; right: 0; bottom: 0;z-index: 1;"></div>
        @if($search_results->isNotEmpty())
            <div class="card position-absolute mt-1" style="z-index: 2;left: 0;right: 0;border: 0;">
                <div class="card-body shadow">
                    <ul class="list-group list-group-flush">
                        @foreach($search_results as $result)
                            <li class="list-group-item list-group-item-action">
                                <a wire:click="resetQuery" wire:click.prevent="selectProduct({{ $result }})" href="#">
                                    {{ $result->product_name }} | {{ $result->product_code }}
                                </a>
                            </li>
                        @endforeach
                        @if($search_results->count() >= $how_many)
                             <li class="list-group-item list-group-item-action text-center">
                                 <a wire:click.prevent="loadMore" class="btn btn-primary btn-sm" href="#">
                                     Load More <i class="bi bi-arrow-down-circle"></i>
                                 </a>
                             </li>
                        @endif
                    </ul>
                </div>
            </div>
        @else
            <div class="card position-absolute mt-1 border-0" style="z-index: 1;left: 0;right: 0;">
                <div class="card-body shadow">
                    <div class="alert alert-warning mb-0">
                       @lang('No Product Found') ....
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
