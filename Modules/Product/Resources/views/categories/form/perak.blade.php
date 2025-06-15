{{-- PERAK --}}


<div class="flex flex-row grid grid-cols-1 gap-2">
<div class="form-group">
    <label for="jenis_perak_id">@lang('Jenis Perak') <span class="text-danger">*</span></label>
    <select class="form-control select2" name="jenis_perak_id" id="jenis_perak_id" required>
        <option value="" selected disabled>Select jenis Perak</option>
        @foreach(\Modules\JenisPerak\Models\JenisPerak::all() as $perak)
         <option value="{{$perak->id}}" {{ old('jenis_perak_id') == $perak->id ? 'selected' : '' }}>
            {{$perak->name}}</option>

        @endforeach
    </select>
</div>
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
<div class="flex flex-row grid grid-cols-3 gap-2">
    
    <div class="form-group">
        <?php
        $field_name = 'berat_emas';
        $field_lable = label_case('Berat');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.01"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


 <div class="form-group">
        <?php
        $field_name = 'berat_accessories';
        $field_lable = label_case('berat_accessories');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.01"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>















    <div class="form-group">
        <?php
        $field_name = 'berat_total';
        $field_lable = label_case('berat_total');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.01"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
</div>