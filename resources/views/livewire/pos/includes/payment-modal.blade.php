<!-- Insert Modal -->
<div wire:ignore.self class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <form  wire:submit.prevent="store">
        @php
        $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping;
         $gtotal = Cart::instance($cart_instance)->total();
         $cart = Cart::instance($cart_instance);
        
        @endphp


        <div class="modal-lg modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-semibold text-lg" id="checkoutModalLabel">
                    <i class="bi bi-cart-check text-primary"></i>
                    Konfirmasi Pembayaran 
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if (session()->has('pesan'))
                <div class="px-3">
                    <div class="alert alert-danger text-dark alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <span>{{ session('pesan') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="text-center justify-center" wire:loading.delay wire:target="togglePanel">
                    <div class="spinner-border load-spinner text-tertiary p-0 me-2"></div>
                </div>
                <div class="text-center justify-center" wire:loading.delay wire:target="btnTransfer">
                    <div class="spinner-border load-spinner text-tertiary p-0 me-2"></div>
                </div>
                @if($showTunai)
                <div class="px-0 py-0 grid grid-cols-2 gap-4 m-2">
                    
                    <input type="hidden" value="{{ $customer_id }}" name="customer_id">
                    <input type="hidden" value="{{ $global_tax }}" name="tax_percentage">
                    <input type="hidden" value="{{ $global_discount }}" name="discount_percentage">
                    <input type="hidden" value="{{ $shipping }}" name="shipping_amount">
                    <input type="hidden" value="Other" name="payment_method">
                    <div class="px-1">
                        <div class="form-group mt-0">
                            <label for="total_amount">Total <span class="text-danger">*</span></label>
                            <input
                            id="total_amount"
                            type="text"
                            class="form-control" name="total_amount" value="{{ $total_amount }}" disabled required>
                            {{-- harga asli --}}
                            <input type="hidden" value="{{ $total_with_shipping }}" wire:model="total_amount">
                            {{-- harga asli --}}
                        </div>
                        
                        <div class="form-group">
                            <label for="discount">Discount  <span class="small text-danger">(Nominal)</span></label>
                            <input
                            id="rupiah"
                            type="text"
                            wire:model="diskon"
                            wire:keyup="recalculateTotal()"
                            class="form-control" name="diskon" required>
                        </div>
                        <div class="form-group">
                            <label for="note">Catatan (Jika diperlukan)</label>
                            <textarea  wire:model="keterangan" name="note" id="note" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="px-1">


                        {{--
                        <div class="form-group">
                            <label for="note">Sub Total</label>
                            
                            <input id="sub_total"
                            type="text"
                            class="form-control text-black"
                            wire:model="sub_total"
                            value="{{ $total_amount }}"
                            name="sub_total" readonly>
                        </div>
                        --}}
                        <div class="form-group">
                            <label for="paid_amount">Bayar 
                               

                                <span class="text-danger">*</span></label>
                            <input id="diskon"
                            type="number"
                            class="form-control"
                            value="{{ $gtotal }}"
                            wire:model="paid_amount"
                            wire:keyup="totalbayar()"
                            required>
                            <input type="hidden" wire:model="sub_total_hidden">
                        </div>
                        <div class="form-group">
                            <label for="grand_total">Grand Total <span class="text-danger">*</span></label>
                            <span class="text-red-800 text-3xl"
                            id="gt"></span>
                            <input wire:model="grand_total" id="grand_total" type="text" class="form-control text-black text-2xl"
                            value="{{$grand_total}}" name="grand_total" disabled>
                        </div>
                        <div class="form-group">
                            <label for="kembali">Kembali <span class="text-danger">*</span></label>
                            <span class="text-red-800 text-3xl"
                            id="kembalian"></span>
                            <input
                            type="text"
                            class="form-control"
                            name="kembali"
                            wire:model="kembali"
                            readonly>
                        </div>
                        
                        
                    </div>
                </div>
                @endif
                @if($showTransfer)
                
                <div>dfdfdf</div>
                @endif
                @if($showEdc)
                <div>

                {{ $paid_amount }}

                </div>
                @endif
                <div class="px-0 py-1 grid grid-cols-3 gap-4 m-2 mt-0 mb-2 text-center no-underline">
                    <button class="btn btn-outline-primary"
                    wire:click="togglePanel"
                    wire:loading.attr="disabled"
                    @if($showTunai)
                    disabled
                    @endif>
                    Tunai
                    
                    </button>
                    <button class="btn btn-outline-success"
                    wire:click="btnTransfer"
                    wire:loading.attr="disabled">Transfer
                    
                    </button>
                    <button class="btn btn-outline-warning"
                    wire:click="btnEdc"
                    wire:loading.attr="disabled">EDC
                    
                    </button>
                </div>
                <div id="ModalFooter" class="modal-footer">
                    <div class="flex justify-between">
                        <div></div>
                        <div class="flex gap-2">
                            <button type="button" class="btn py-2 btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="px-20 py-2 btn bg-red-400 text-white">Simpan</button>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@push('page_scripts')
<script>
document.getElementById('rupiah').addEventListener('keyup', function() {
// Get the input value
    let inputValue = this.value;
    inputValue = inputValue.replace(/[^0-9.]/g, '');
    inputValue = parseFloat(inputValue).toLocaleString('en-ID');
    this.value = inputValue;

});
document.getElementById('diskon').addEventListener('keyup', function() {
// Get the input value
    let inputValue = this.value;
    inputValue = inputValue.replace(/[^0-9.]/g, '');
    inputValue = parseFloat(inputValue).toLocaleString('en-ID');
    this.value = inputValue;

});
</script>
@endpush
@push('page_css')
<style type="text/css">
.form-group {
   margin-bottom: 0.2rem;
}
label {
    display: inline-block;
    margin-bottom: 0.1rem;
}
</style>
@endpush