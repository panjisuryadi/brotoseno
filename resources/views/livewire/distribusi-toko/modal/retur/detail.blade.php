<div class="modal fade" id="retur-detail" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title text-lg font-bold" id="addModalLabel">Detail Retur Item</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body p-4">
            <img src="{{ asset(imageUrl().$data['additional_data']['image']) }}" alt="">
        </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script>
    
</script>
@endpush