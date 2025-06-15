<div class="form-group">
    <label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
    <input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
</div>
<div class="flex relative py-1">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
        </span>
    </div>
</div>
<div class="flex row px-3 py-0">
    {{-- =================================================================================== --}}
    <div class="form-row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="berat_emas">@lang('Berat') <span class="text-danger">*</span></label>
                <input min="0" step="0.01" id="berat_emas" type="number" class="form-control" name="berat_emas" required value="{{ old('berat_emas') }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="berat_accessories">@lang('Berat Accessories') <span class="text-danger">*</span></label>
                <input min="0" step="0.01" id="berat_accessories" type="number" class="form-control" name="berat_accessories" required value="{{ old('berat_accessories') }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="berat_label">@lang('Berat Label') <span class="text-danger">*</span></label>
                <input min="0" step="0.01" id="berat_label" type="number" class="form-control" name="berat_label" required value="{{ old('berat_label') }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="berat_total">@lang('Berat Total') <span class="text-danger">*</span></label>
                <input min="0" step="0.01" id="berat_total" type="number" class="form-control" name="berat_total" required value="{{ old('berat_total') }}">
            </div>
        </div>
    </div>
    {{-- =================================================================================== --}}
</div>
<div class="flex relative py-1">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Harga</span>
    </div>
</div>
<div class="flex row px-3 py-0">
    {{-- harga =================================================================================== --}}
    <div class="form-row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="product_price">@lang('Price') <span class="text-danger">*</span></label>
                <input id="product_price" type="text" class="form-control" name="product_price" required value="{{ old('product_price') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="product_cost">@lang('Cost') <span class="text-danger">*</span></label>
                <input id="product_cost" type="text" class="form-control" name="product_cost" required value="{{ old('product_cost') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="product_sale">@lang('Jual') <span class="text-danger">*</span></label>
                <input id="product_sale" type="text" class="form-control" name="product_sale" required value="{{ old('product_sale') }}">
            </div>
        </div>
    </div>
    {{-- =================================================================================== --}}
</div>
<div class="flex relative py-0">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Lokasi <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Lokasi Penyimpanan (Gudang /Rak etc."></i></span>
    </div>
</div>
{{-- =================================================================================== --}}
<div class="form-row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="gudang_id">@lang('Gudang') <span class="text-danger">*</span></label>
            <select class="form-control select2" name="gudang_id" id="gudang_id" required>
                <option value="" selected disabled>Select Gudang</option>
                @foreach(\Modules\Gudang\Models\Gudang::all() as $gudang)
                <option value="{{$gudang->id}}" {{ old('gudang_id') == $gudang->id ? 'selected' : '' }}>
                {{$gudang->code}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="etalase_id">@lang('Etalase') <span class="text-danger">*</span></label>
            <select class="form-control select2" name="etalase_id" id="etalase_id" required>
                <option value="" selected disabled>Select Etalase</option>
                @foreach(\Modules\DataEtalase\Models\DataEtalase::all() as $et)
                <option value="{{$et->id}}" {{ old('etalase_id') == $et->id ? 'selected' : '' }}>
                {{$et->code}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="baki_id">@lang('Baki') <span class="text-danger">*</span></label>
            <select class="form-control select2" name="baki_id" id="baki_id" required>
                <option value="" selected disabled>Kode Baki</option>
                @foreach(\Modules\Baki\Models\Baki::all() as $bk)
                <option value="{{$bk->id}}" {{ old('baki_id') == $bk->id ? 'selected' : '' }}>
                {{$bk->code}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
{{-- =================================================================================== --}}
<div class="flex row px-3 py-0">
    <div class="p-0 col-lg-12">
        <div class="form-group">
            <label for="product_note">Note</label>
            <textarea name="product_note" id="product_note" rows="4 " class="form-control"></textarea>
        </div>
    </div>
</div>
</div>
</div>