<div>
 <?php
    $result = array (
    'total_with_shipping' => $total_with_shipping,
    'qty' => $jumlah ?? 0,
    'total_amount' => $total_amount ?? 0,
    );
?>
{{-- @foreach($cart as $row)
{{$row}}
@endforeach --}}

<div class="form-group mt-4">
    <label for="total_amount">Total <span class="text-danger">*</span></label>
    <input id="total_amount" type="text" class="form-control" name="total_amount" value="{{ $total_amount }}" readonly required>
</div>
</div>
