   <div>
             @if($selectedOption == 'logam-mulia')

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


<div class="flex relative py-1">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
        </span>
    </div>
</div>




<div class="flex flex-row grid grid-cols-2 gap-2">
    
    <div class="form-group">
        <?php
        $field_name = 'berat_emas';
        $field_lable = label_case('Emas');
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
        wire:model="berat_emas"
        wire:change="recalculateTotal"
        wire:keyup="recalculateTotal"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
    <div class="form-group">
        <?php
        $field_name = 'berat_total';
        $field_lable = label_case('Total');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{$beratTotalFinal}}" readonly>

        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
</div>

  {{-- @include('product::categories.form.lm') --}}
 @else
<div class="grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="product_note">Kategori Emas</label>
        <select class="form-control select2" name="gold_kategori_id" id="gold_kategori_id" required>
            @foreach(\Modules\GoldCategory\Models\GoldCategory::all() as $sup)
            <option value="{{$sup->id}}" {{ old('gold_kategori_id') == $sup->id ? 'selected' : '' }}>
            {{$sup->name}}</option>
            @endforeach
        </select>
   @if($errors->has('gold_kategori_id'))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first('gold_kategori_id') }}.</small
        class="text-danger">
    </span>
    @endif

    </div>
    <div class="form-group">
        <label for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="karat_id" id="karat_id" required>
           
            @foreach(\Modules\Karat\Models\Karat::all() as $jp)
            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- BERAT --}}

<div class="flex relative py-1">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
        </span>
    </div>
</div>
<div class="flex flex-row grid grid-cols-4 gap-2">
    
   <div class="form-group">
        <?php
        $field_name = 'berat_accessories';
        $field_lable = label_case('Accessories');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
         step="0.001"
        wire:model="berat_accessories"
        wire:change="recalculateTotal"
        wire:keyup="recalculateTotal"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}"
        >
        @if ($errors->has('berat_accessories'))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first('berat_accessories') }}.</small
            class="text-danger">
        </span>
        @endif
    </div>

  <div class="form-group">
        <?php
        $field_name = 'berat_tag';
        $field_lable = label_case('Tag');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        wire:model="berat_tag"
        wire:change="recalculateTotal"
        wire:keyup="recalculateTotal"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>

    <div class="form-group">
        <?php
        $field_name = 'berat_emas';
        $field_lable = label_case('Emas');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        wire:model="berat_emas"
        wire:change="recalculateTotal"
        wire:keyup="recalculateTotal"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
    <div class="form-group">
        <?php
        $field_name = 'berat_total';
        $field_lable = label_case('Total');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{$beratTotalFinal}}" readonly>

        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
</div>
{{-- END BERAT --}}
 @endif
  </div>


                  


