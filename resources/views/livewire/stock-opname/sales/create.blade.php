<div class="row mt-0 p-3">


    <div class="col-md-5 bg-white">
        <div class="pt-3">
            @if($active_location['id'] == '2')
            <?php
            $model = "Modules\Stok\Models\StockSales";
            ?>
            <livewire:stock-opname.sales.table :active_location="$active_location" :model="$model" />
            @endif
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">

            <div class="card-body">
                @include('utils.alerts')
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="reference">Reference <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="reference" wire:model="reference" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="from-group">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" name="date" wire:model="date" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="tablelist">
                            <thead>
                                <tr class="align-middle">
                                    <th class="align-middle">@lang('Product Name')</th>
                                    <th class="align-middle">@lang('Nama Sales')</th>
                                    <th class="align-middle">Stock Data</th>
                                    <th class="align-middle">@lang('Stock Rill')</th>
                                    <th class="align-middle">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adjustment_items as $index => $item )
                                <tr>
                                    <td>{{ $item['product_name'] }}</td>
                                    <td>{{ $item['sales_name'] }}</td>
                                    <td>{{ $item['current_stock'] }}</td>
                                    <td>{{ $item['new_stock'] }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" wire:click="remove({{ $index }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    <div class="form-group">
                        <label for="notes">Note <span class="small text-danger">( @lang('If Needed'))</span></label>
                        <textarea wire:model="note" name="notes" id="notes" rows="3" class="form-control"></textarea>
                    </div>




                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            @lang('Create Adjustment') <i class="bi bi-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('alreadySelected', function () {
            toastr.error('Item sudah dipilih!');
        });
    });
</script>

@endpush