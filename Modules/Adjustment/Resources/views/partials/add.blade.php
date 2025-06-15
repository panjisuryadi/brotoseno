<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
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
                        <div>Name</div>
                        <div><b><span id="product_name">NAGATA</span></b></div>
                    </div>
                    <div class="col-md-6">
                        <div>Location</div>
                        <div><b><span id="location">Gudang A1</span></b></div>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">Stock Data</label>
                            <input type="text" name="stock" id="stock" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock_rill" class="">Stock Rill</label>
                            <input type="text" name="stock_rill" id="stock_rill" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" onclick="addtolist()">Tambahkan</button>
        </div>
        </div>
    </div>
</div>