 
<?php
    $result = array (
    'total_with_shipping' => $total_with_shipping,
    'qty' => $jumlah ?? 0,
    'total_amount' => $total_amount ?? 0,
    'bayar' =>  0,
    );
?>

 <button class="text-center  hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center" 
    role="button" 
    data-toggle="modal" 
    data-target="#simpanModal{{$result['total_with_shipping']}}">
        <i class="hover:text-red-400 bi bi-box-arrow-down md:text-4xl text-4xl text-gray-500"></i>
         <div class="lg:text-sm md:text-sm text-xl py-0 font-semibold">Simpan</div>
    
        </button>

<!-- Discount Modal -->
<div wire:ignore.self class="modal fade" id="simpanModal{{$result['total_with_shipping']}}" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="relative modal-title" id="discountModalLabel">
                    Save 
                   
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  method="POST">
     <div style="text-align:left !important;" class="modal-body items-baseline">
         <div class="form-group">
        <label for="note">Catatan (Jika diperlukan)</label>
        <textarea name="note" id="note" rows="3" class="form-control"></textarea>
    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="px-5 btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
