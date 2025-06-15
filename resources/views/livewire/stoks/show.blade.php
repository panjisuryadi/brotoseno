<div class="card">
    <div class="card-header d-flex flex-wrap align-items-center">
        <div>
            <h2 class="text-lg font-bold uppercase">detail stok pending</h2>
        </div>
        <a class="btn  mfs-auto btn-sm btn-success mfe-1" href="/"><i class="bi bi-house-door"></i>
            Dashboard
        </a>
    </div>
    {{--    @dump($details)--}}
    <div class="card-body">
        <div class="table-responsive">
            <table style="width: 100% !important;"
                   class="w-full table table-sm table-striped rounded-lg table-bordered">
                <thead>
                <tr>
                    <th class="text-center">
                        <div class="p-1">
                            <input type="checkbox" wire:model="selectAll" id="select-all">
                        </div>
                    </th>
                    <th class="text-center">No</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Code</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Berat</th>
                </tr>
                </thead>
                <tbody>
                @forelse($details as $row => $detail)
                    @php
                        $total_weight =+ $detail->berat_emas;
                        $image = $detail->images;
                        $imagePath = '';
                        if(empty($image)){
                            $imagePath = url('images/fallback_product_image.png');
                        }else{
                            $imagePath = asset(imageUrl().$image);
                        }
                    @endphp
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" wire:model="selectedItems" value="{{$detail->id}}"
                                   name="selected_items[]"/>
                        </td>
                        <td class="text-center">{{$row + 1}}</td>
                        <td class="text-center">
                            <strong class="text-medium">{{@$detail->product_name}}</strong>
                        </td>
                        <td class="text-center">
                            <strong class="text-warning">{{@$detail->product_code}}</strong>
                        </td>
                        <td class="text-center">{{$detail->category->category_name}}</td>
                        <td class="text-center text-danger">{{formatWeight($detail->berat_emas)}}</td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="8" class="text-center">Tidak ada Data</th>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="flex justify-end items-center mt-1 gap-3">
                <div>
                    <span class="font-bold text-gray-800-500">
                        <div>
                    <input type="number" wire:model="weightTarget" placeholder="Enter target weight (in grams)"
                           class="w-full rounded-lg border py-2 px-3">
                        </div>
                    <table style="width: 100% !important;" class="w-full table table-sm table-borderless rounded-lg">
                        <tr>
                            <td>Jumlah Barang</td>
                            <td>{{ count($selectedItems) }}</td>
                        </tr>
                        <tr>
                            <td>Total Berat</td>
                            <td>{{formatBerat($totalWeight)}}</td>
                        </tr>
                    </table>
                    </span>

                </div>
                <div>
                    <a href="#" class="px-5 btn btn-lg btn-success" wire:click.prevent="proses">Proses</a>
                </div>
            </div>
        </div>
    </div>

   @include('stok::stoks.modal.confirm')

</div>
