<div class="modal fade" id="summary-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Konfirmasi Pengiriman Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                @php
                    $selected_count = count($selectedItems);
                @endphp
                <p>Jumlah Barang dikirim : <strong>{{ $selected_count }}</strong> buah</p>
                <div class="form-group mt-3">
                    <label for="note" class="font-medium">Catatan / Berita Acara</label>
                    <textarea id="note" class="form-control" wire:model="note" cols="30" rows="10" placeholder="Tulis disini..."></textarea>
                    @if($errors->has('note'))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first('note') }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" wire:click.prevent="send">
                    @lang('Kirim ke Office') 
                </button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script>


</script>
@endpush