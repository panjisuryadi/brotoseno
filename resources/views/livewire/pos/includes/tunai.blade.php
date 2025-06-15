<<div class="px-0 py-2 grid grid-cols-2 gap-4 m-2">


<input type="hidden" value="{{ $customer_id }}" name="customer_id">
    <input type="hidden" value="{{ $global_tax }}" name="tax_percentage">
    <input type="hidden" value="{{ $global_discount }}" name="discount_percentage">
    <input type="hidden" value="{{ $shipping }}" name="shipping_amount">
    <input type="hidden" value="Other" name="payment_method">



<div class="px-1">
<div class="form-group mt-0">
    <label for="total_amount">Total <span class="text-danger">*</span></label>
    <input id="total_amount" type="text" class="form-control" name="total_amount" value="{{ $total_amount }}" disabled required>
    <input type="hidden" id="harga" name="harga_awal" value="{{ $total_amount }}">
</div>


<div class="form-group">
    <label for="note">Catatan (Jika diperlukan)</label>
    <textarea name="note" id="note" rows="2" class="form-control"></textarea>
</div>



<div class="form-group">
    <label for="discount">Discount  <span class="small text-danger">(Nominal)</span></label>
    <input  id="discount" type="text" class="form-control" name="discount">
    <input type="hidden" id="diskon2">
</div>




</div>


<div class="px-1">

<label for="tunaiRadio">Tunai</label>
<input type="radio" name="tipebayar" id="tunaiRadio" value="tunai" checked required>

<label for="cicilRadio">Cicilan</label>
<input type="radio" name="tipebayar" id="cicilRadio" value="cicil">

<div id="Tunai" class="px-0">
   <div class="form-group">
    <label for="tunai">Bayar Tunai<span class="text-danger">*</span></label>
    <input id="input_tunai" type="text" class="form-control" name="tunai">
    <div style="display: none;" id="kembalian-info">Kembali: <span class="text-blue-500 text-xl" id="kembalian">0</span></div>
</div>
</div>

<div id="cicilan" style="display: none;">
 <div class="form-group">
    <label for="ciclan">Jatuh Tempo<span class="text-danger">*</span></label>
    <input id="tgl_jatuh_tempo" type="date" class="form-control" name="tgl_jatuh_tempo">

</div>

</div>

<div class="form-group">
    <label for="note">Grand Total</label> <span class="text-danger small" id="message"></span>
    {{-- <span id="final" class="text-black text-4xl"></span> --}}
    <input id="final" type="text" class="form-control text-black text-2xl" name="final" value="{{ $total_amount }}" disabled>
    <input value="{{ $total_amount }}" id="final_unmask" type="hidden" class="form-control" name="final_unmask">


</div>





</div>



</div>
