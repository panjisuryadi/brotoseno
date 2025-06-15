<div class="grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="product_note">Kategori Emas</label>
        <select class="form-control select2" name="gold_kategori_id" id="gold_kategori_id" required>
            <option value="" selected disabled>Select Kategori</option>
            @foreach(\Modules\GoldCategory\Models\GoldCategory::all() as $sup)
            <option value="{{$sup->id}}" {{ old('gold_kategori_id') == $sup->id ? 'selected' : '' }}>
            {{$sup->name}}</option>
            @endforeach
        </select>
    </div>

 <div class="form-group">
        <label for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
         <select class="form-control select2" name="karat_id" id="karat_id" required>
            <option value="" selected disabled>Karat</option>
            @foreach(\Modules\Karat\Models\Karat::all() as $jp)
            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
            @endforeach
        </select>
    </div>


</div>