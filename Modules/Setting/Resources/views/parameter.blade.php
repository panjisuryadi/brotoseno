<div class="grid grid-cols-5 gap-2">

  <div class="form-group">
        <label for="toleransi_berat">Toleransi Berat<span class="text-danger">*</span></label>
        <input type="number" step="0.1" class="form-control" name="toleransi_berat" value="{{ $settings->toleransi_berat }}" required>
    </div>

<div class="form-group">
        <label for="rfid">RFID Length<span class="text-danger">*</span></label>
        <input type="number" min="1" class="form-control" name="rfid" value="{{ $settings->rfid }}" required>
    </div>

<div class="form-group">
        <label for="discount">Discount<span class="text-danger">*</span></label>
        <input type="number" min="0" class="form-control" name="discount" value="{{ $settings->discount }}" required>
    </div>

<div class="form-group">
        <label for="margin">Margin<span class="text-danger">*</span></label>
        <input type="number" min="0" class="form-control" name="margin" value="{{ $settings->margin }}" required>
    </div>


<div class="form-group">
        <label for="poin">Poin<span class="text-danger">*</span></label>
        <input type="number"  class="form-control" name="poin" value="{{ $settings->poin }}" required>
    </div>


    
 </div>