<div>
    <div class="col-md-12">
        <!-- Search box -->


        <div class="row">
       <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Cari Produk" style="width: 100%;" wire:model="searchTerm" >
        </div>
    </div>
       <div class="col-md-6 col-sm-6">
        <div class="form-group">

                <select wire:model="cariLokasi" wire:change="getDestination($event.target.value)" class="form-control">
                    <option value="">Pilih Lokasi</option>
                    @foreach($main as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                     @if(!empty($p->childs))
                            @foreach($p->childs as $loc1)
                            <option value="{{ $loc1->id }}">> {{ $loc1->name }}</option>
                                @if(!empty($loc1->childs))
                                    @foreach($loc1->childs as $loc2)
                                    <option value="{{ $loc2->id }}"> &nbsp;=> {{ $loc2->name }}</option>
                                        @if(!empty($loc2->childs))
                                            @if(!empty($loc2->childs))
                                                @foreach($loc2->childs as $loc3)
                                                <option value="{{ $loc3->id }}">&nbsp;==> {{ $loc3->name }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                </select>


        </div>


       </div>

        </div>
        <!-- Paginated records -->
        
        <table class="table table-sm table table-striped" style="width: 100%;">
            <thead>
                <tr>
                     <th class="no-sort text-center">No</th>
                    <th class="sort" wire:click="sortOrder('product_name')">Nama Produk {!! $sortLink !!}</th>
                    <th class="sort" wire:click="sortOrder('location_id')">Lokasi {!! $sortLink !!}</th>
                    <th class="no-sort text-center">Stok</th>
                    <th class="no-sort text-center">Unit</th>
                    <th class="no-sort text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count())
                @foreach ($products as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->product->product_name }} {{$row->product->product_code}} {{$row->product->meter}}</td>
                    <td>{{ $row->location->name }}</td>
                    <td class="text-center">{{ $row->stock }}</td>
                    <td class="text-center">{{ $row->product->product_unit }}</td>
                    <td>
            <div wire:click.prevent="selectProduct({{ $row }})"
            class="w-100 btn btn-sm btn-outline-success "
            style="cursor: pointer;"
            >

              {{--          @if($row->id_produk == $pilih[])
                       dipilih
                        @else
                        tidak
                        @endif --}}

                           Add - {{ $pilih }}
                        </div>
             </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" align="center">No record found</td>
                </tr>
                @endif
            </tbody>
        </table>
        <!-- Pagination navigation links -->
        {{ $products->links() }}
    </div>
</div>