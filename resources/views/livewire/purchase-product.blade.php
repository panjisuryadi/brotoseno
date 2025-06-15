<div class="position-relative">
    <div wire:loading class="position-absolute mt-1 border-0" style="z-index: 10;left: 0;right: 0;">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-0 border-0">
        <div class="px-0">
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text p-0">
                        <i class="text-xs px-2 bi bi-search text-primary"></i>
                    </div>
                </div>
                <input wire:keydown.escape="resetQuery" wire:model.debounce.500ms="query" type="text" class="form-control form-control-sm" placeholder="@lang('Type product name or code') ....">
            </div>
            @if(!empty($query))
            <div wire:click="resetQuery" class="position-fixed w-100 h-100" style="left: 0; top: 0; right: 0; bottom: 0;z-index: 1;"></div>
            @if($search_results->isNotEmpty())
            <div class="card position-absolute mt-1" style="z-index: 2;left: 0;right: 0;border: 0;">
                <div class="card-body px-2 py-1">
                    <ul class="flex flex-col divide-y divide">
                        @foreach($search_results as $result)
                        <li class="flex flex-row border-bottom">
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
               @lang('No Product Found') ....
              @endif
            @endif
            <ul class="flex flex-col divide-y divide">
                @if($list_product->isNotEmpty())
                @foreach ($list_product as $row)
                <li class="flex flex-row border-bottom">
                    <div class="flex items-center flex-1 p-2 cursor-pointer select-none">
                        <div class="flex flex-col mt-2 items-center justify-center w-10 h-10 mr-2">
                            <a wire:click.prevent="selectProduct({{ $row }})" href="#" class="relative block">
                                <img alt="profil" src="{{ $row->getFirstMediaUrl('images', 'thumb') }}" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                            </a>
                        </div>
                        <div class="flex-1 pl-1 mr-16">
                            <div class="font-semibold">
                                <a wire:click.prevent="selectProduct({{ $row }})"
                                    href="#" class="hover:no-underline hover:text-gray-400">
                                    {{ $row->product_name }}
                                </a>
                            </div>
                            <div class="text-xs small text-gray-600">
                                <span class="badge badge-success"> {{ $row->product_code }} </span>
                                <span class="font-normal">
                                | {{ $row->category->category_name }} | {{ number_format($row->product_price) }}</span>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <a wire:click.prevent="selectProduct({{ $row }})"
                                href="#" class="py-0 btn btn-sm btn-outline-success mr-1">
                                Add
                            </a>
                            <button  wire:click="hapusItem({{ $row->id }})"
                            class="py-0 btn btn-sm btn-outline-danger">
                            Hapus
                            </button>
                        </div>
                    </div>
                </li>
                @endforeach
                @if($list_product->count() >= $how_many)
                <li class="flex flex-row">
                    <div class="flex flex-col items-center justify-center py-2 w-full">
                        <a wire:click.prevent="loadMore" class="btn btn-primary btn-sm" href="#">
                            Load More <i class="bi bi-arrow-down-circle"></i>
                        </a>
                    </div>
                </li>
                @endif
                @else
                   @lang('No Product Found') ....
                @endif
            </ul>
        </div>
    </div>
</div>