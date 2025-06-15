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
                    <select name="sales_id" id="sales_id" wire:model="sales_id" class="form-control">
                        @foreach ($datasales as $sales )
                        <option value="{{ $sales->id }}">{{$sales->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
       <div class="col-md-6 col-sm-6">
        <div class="form-group">

        </div>


       </div>

        </div>
        <!-- Paginated records -->
        <div class="table-responsive">
        <table class="table table-sm table-striped" style="width: 100%;">
            <thead>
                <tr>
                     <th class="no-sort text-center">No</th>
                    <th class="no-sort">Karat</th>
                    <th class="no-sort">Stok</th>
                    <th class="no-sort text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count())
                @foreach ($products as $key => $value)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $value->karat?->label}}</td>
                    <td>{{ $value->weight }}</td>
                    <td>
            <button wire:click="selectProduct('{{ $value->id }}')"
            class="w-100 btn btn-sm btn-outline-success "
            style="cursor: pointer;"> Tambah
                        </button>
             </td>
                </tr>
                @livewire('stock-opname.sales.modal', ['data'=>$value,'key'=>$value->id,'active_location' => $active_location['label']],key('modal-'.$value->id))
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
    
</div>


@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('showModal', function(data){
            $("#addModal"+data.modalId).modal('show');
        });
        Livewire.on('closeModal', function (data) {
            $("#addModal"+data.modalId).modal('hide');
        });
    });
</script>

@endpush