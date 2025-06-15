<div class="modal fade" id="addModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="addModalLabel">Detail</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" id="formadd">
                <div class="row">
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="product_name_val" id="product_name_val">
                    <input type="hidden" name="location_val" id="location_val">
                    <input type="hidden" name="location_id" id="location_id">
                    <input type="hidden" name="product_location_id" id="product_location_id">
                    <div class="col-md-6">
                        <div>Karat</div>
                        <div><b><span id="product_name">{{ $data->karat->label }}</span></b></div>
                    </div>
                    <div class="col-md-6">
                        <div>Location</div>
                        <div><b><span id="location">{{ $active_location }}</span></b></div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">Stock Data</label>
                            <input type="text" name="stock" id="stock" class="form-control" readonly value="{{$data->berat_real}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock_rill" class="">Stock Rill</label>
                            <input type="number" wire:model.defer="stock_rill" id="stock_rill" class="form-control" step="0.001">
                            @if ($errors->has('stock_rill'))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first('stock_rill') }}.</small
                                    class="text-danger">
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" wire:click="add()">Tambahkan</button>
        </div>
        </div>
    </div>
</div>