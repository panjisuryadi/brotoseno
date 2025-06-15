<div>
    <div class="form-group">
        <?php
        $field_name = 'kadar';
        $field_lable = label_case('kadar');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" wire:change="updateKarat">
            <option value="" selected disabled>Pilih Karat</option>
            @foreach($allKarat as $karat)
            <option value="{{ $karat->id }}">{{ $karat->label }}</option>
            @endforeach
        </select>
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
        </span>
        @endif
    </div>
    <div class="form-group">
        <?php
        $field_name = 'kode';
        $field_lable = label_case('kode');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input type="text" class="form-control" readonly wire:model="{{ $field_name }}">
    </div>
    <div class="form-group">
        <?php
        $field_name = 'berat';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control" type="number" name="{{ $field_name }}" min="0" step="0.001" id="{{ $field_name }}" value="{{old($field_name)}}" placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
        </span>
        @endif
    </div>
</div>