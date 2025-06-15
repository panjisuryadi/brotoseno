<div class="grid grid-cols-3 gap-3">
<div class="form-group">
	<label for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
	<select class="form-control select2" name="karat_id" id="karat_id" required>
		<option value="" selected disabled>Select Karat</option>
		@foreach(\Modules\Karat\Models\Karat::all() as $karat)
		<option value="{{ $karat->id }}">{{ $karat->label }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label for="round_id">@lang('Round') <span class="text-danger">*</span></label>
	<select class="form-control select2" name="round_id" id="round_id" required>
		<option value="" selected disabled>Select Round</option>
		@foreach(\Modules\ItemRound\Models\ItemRound::all() as $round)
		<option value="{{ $round->id }}">{{ $round->name }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label for="shape_id">@lang('Shape') <span class="text-danger">*</span></label>
	<select class="form-control select2" name="shape_id" id="shape_id" required>
		<option value="" selected disabled>Select Shape</option>
		@foreach(\Modules\ItemShape\Models\ItemShape::all() as $shape)
		<option value="{{ $shape->id }}">{{ $shape->name }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label for="certificate_id">@lang('Certificate') <span class="text-danger">*</span></label>
	<select class="form-control select2" name="certificate_id" id="certificate_id" required>
		<option value="" selected disabled>Select Certificate</option>
		@foreach(\Modules\DiamondCertificate\Models\DiamondCertificate::all() as $certificate)
		<option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
	<input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
</div>

</div>