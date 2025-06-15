<div class="flex flex-row grid grid-cols-2 gap-2">
<div class="form-group">
    <label for="shape_id">@lang('Shape') <span class="text-danger">*</span></label>
    <select class="form-control" name="shape_id" id="shape_id" required>
        <option value="" selected disabled>Select Shape</option>
        @foreach(\Modules\ItemShape\Models\ItemShape::all() as $shape)
        <option value="{{ $shape->id }}">{{ $shape->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
    <input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
</div>

</div>