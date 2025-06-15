<div class="grid grid-cols-2 gap-2">

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