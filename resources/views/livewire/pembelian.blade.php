<div class="position-relative">
    <div wire:loading class="position-absolute mt-1 border-0" style="z-index: 10;left: 0;top: 10;right: 0;">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-0 border-0">
        <div class="px-2">
            <div class="form-group" style="z-index: 4;">
                <label for="reference">Pencarian <span class="text-danger">*</span></label>
                <input class="form-control" wire:keydown.escape="resetQuery" wire:model.debounce.500ms="query"
                wire:click="clickQuery"
                type="text"
                placeholder="@lang('Type product name or code')">
            </div>
        </div>
    </div>
    @if(!empty($query))
    <div wire:click="resetQuery" class="position-fixed w-100 h-100" style="left: 0; top: 0; right: 0; z-index: 0;"></div>
    @if($search_results->isNotEmpty())
    <div class="card position-absolute mt-0 overflow-y-auto h-120"
        style="width: 360px !important;z-index: 3;left: 0;
        border: 1px solid #f0f0ef !important;">
        <div class="card-body px-2 py-1">
            <ul class="flex flex-col divide-y divide">
                @foreach($search_results as $result)
                <li class="flex flex-row">
                    <div class="flex items-center flex-1 p-2 cursor-pointer select-none">
                        <div class="flex flex-col mt-2 items-center justify-center w-10 h-10 mr-2">
                            <a wire:click.prevent="selectProduct({{ $result }})" href="#" class="relative block">
                                <img alt="profil" src="{{ $result->getFirstMediaUrl('images', 'thumb') }}" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                            </a>
                        </div>
                        <div class="flex-1 pl-1 mr-16">
                            <div class="font-semibold">
                                <a wire:click.prevent="selectProduct({{ $result }})"
                                    href="#" class="hover:no-underline hover:text-gray-400">
                                    {{ $result->product_name }}
                                </a>
                            </div>
                            <div class="text-xs small text-gray-600">
                                <span class="badge badge-success"> {{ $result->product_code }} </span>
                                <span class="font-normal">
                                | {{ $result->category->category_name }} | {{ number_format($result->product_price) }}</span>
                            </div>
                        </div>

                    <div class="flex justify-end">
                            <a wire:click.prevent="selectProduct({{ $result }})"
                                href="#" class="py-0 btn btn-sm btn-outline-success mr-1">
                                Add
                            </a>
                            @if($result->status == 3)
                            <button wire:click="hapusItem({{ $result->id }})"
                            class="py-0 btn btn-sm btn-outline-danger">
                            Hapus
                            </button>
                            @endif
                        </div>

                </div>
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
      <div class="card position-absolute mt-0" style="width: 340px !important;z-index: 2;left: 0;right: 0;border: 0;border: 1px solid #f0f0ef !important;">

        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded relative" role="alert">
            <span class="block sm:inline"> @lang('No Product Found') ....</span>
             {{--    <span class="absolute top-0 bottom-0 right-0 px-2 py-3">
                    @if(! request()->routeIs('product-transfer-type.*'))
                    <a  href="{{ route('products.create-modal') }}" id="Tambah" class="py-0 btn btn-sm btn-outline-danger mr-1">
                        @lang('Add New Product')
                    </a>
                    @endif
                </span> --}}
        </div>




    </div>
    @endif
    @endif
</div>