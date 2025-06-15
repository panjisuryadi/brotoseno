<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="detailmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="detailmodalLabel">Ubah Status</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form-status">
                    <div id="modal-content">
                        @csrf
                        <input type="hidden" name="data_id" id="data_id"  value="">
                        <div class="flex">
                            <select class="form-control uppercase" name="status_id" id="status_id" required>

                                <option value="" disabled>PENDING</option>

                                @foreach($proses_statuses as $status)
                                <option value="{{$status->id}}" class="uppercase">
                                    {{ $status->name }}
                                </option>
                                @endforeach


                            </select>
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