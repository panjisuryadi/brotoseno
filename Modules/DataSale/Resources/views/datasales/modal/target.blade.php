<div class="modal fade" id="modaltarget" tabindex="-1" role="dialog" aria-labelledby="detailmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="detailmodalLabel">Ubah Target</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" id="form-target">
                @csrf
                <input type="hidden" name="sale_id" value="{{$detail->id}}">
            <div id="modal-content">
                <div class="flex">
                    <div class="flex-1">
                        <div class="form-group">
                            <label for="">Target</label>
                            <input type="number" name="target" id="target" min="0" step="0.001" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
        </div>
    </div>
</div>