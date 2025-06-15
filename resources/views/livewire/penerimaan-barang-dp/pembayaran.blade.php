<div class="grid grid-cols-1 gap-3 items-start">
    <div class="form-group">
        <?php
        $field_name = 'nominal_dp';
        $field_lable = label_case('nominal_dp');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-left mb-0" for="{{ $field_name }}">{{ $field_lable }}<small class="text-danger">*</small></label>
        <input type="number" name="{{$field_name}}" class="form-control" placeholder="{{$field_placeholder}}">
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
        </span>
        @endif
    </div>

    <div class="form-group">
        <?php
        $field_name = 'tipe_pembayaran';
        $field_lable = label_case('tipe_pembayaran');
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">Tipe Pembayaran <span class="text-danger">*</span></label>
        <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
            <option value="" selected disabled>Pilih {{ $field_lable }}</option>
            <option value="cicil">Cicil</option>
            <option value="jatuh_tempo">Jatuh Tempo</option>
            <option value="lunas">Lunas</option>
        </select>
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
        </span>
        @endif
    </div>

    @if ($this->tipe_pembayaran == 'cicil')
    <div id="cicilan" class="form-group">
        <?php
        $field_name = 'cicil';
        $field_lable = __('cicil');
        $field_placeholder = Label_case($field_lable);
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = '';
        ?>
        <label for="{{ $field_name }}"> {{ $field_placeholder }} <span class="text-danger">*</span></label>
        <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
            <option value="" selected disabled>Jumlah {{ $field_name }}an</option>
            <option value="1">1 kali</option>
            <option value="2">2 kali </option>
        </select>
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
        </span>
        @endif
    </div>
    @elseif ($this->tipe_pembayaran == 'jatuh_tempo')
    <div id="jatuh_tempo" class="form-group">
        <?php
        $field_name = 'tgl_jatuh_tempo';
        $field_lable = __('Tanggal');
        $field_placeholder = Label_case($field_lable);
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
        <input type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{$field_name}}_input" wire:model="{{ $field_name }}"  placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
        </span>
        @endif
    </div>
    @endif
</div>