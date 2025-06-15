<form wire:submit.prevent="store">
    @csrf

    <div class="grid grid-cols-3 gap-2">
        <div class="form-group">
            <?php
            $field_name = 'jenis';
            $field_lable = __('jenis');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                Pilih Data yang ingin dibuat</label>
            <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                <option value="" selected>Pilih Karat / Kategori Karat</option>
                <option value="1">Karat</option>
                <option value="2">Kategori Karat</option>
            </select>
        </div>
        <div class="form-group col-span-2 flex items-center justify-center">
            <h2 class="text-3xl font-bold text-black">{{ $this->karat_label }}</h1>
        </div>
    </div>
    <div class="flex flex-row grid grid-cols-3 mb-0 gap-2">

        <div class="form-group @if ($jenis != 2) hidden @endif">
            <?php
            $field_name = 'karat.parent_id';
            $field_lable = __('Karat');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                {{ $field_lable }}</label>
            <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                <option value="" selected>Pilih Karat</option>
                @foreach($dataKarat as $karat)
                <option value="{{$karat->id}}">
                    {{$karat->label}}
                </option>
                @endforeach
            </select>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>

        <div class="form-group @if ($jenis == '') hidden @endif">
            <?php
            $field_name = 'karat.name';
            $field_lable = __('Nama');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                {{ $field_lable }}<span class="text-danger">*</span>
            </label>
            <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}" wire:ignore>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>

        <div class="form-group @if ($jenis != 1) hidden @endif">
            <?php
            $field_name = 'karat.kode';
            $field_lable = label_case('Kode');
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}" wire:ignore>
            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>  
</div>

 <div class="flex flex-row grid grid-cols-3 mb-0 gap-2">

        <div class="form-group @if ($jenis != 1) hidden @endif">
            <?php
            $field_name = 'karat.coef';
            $field_lable = label_case('coef');
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
            <input class="form-control" 
            type="number" 
            name="{{ $field_name }}" 
            step="0.01" 
            id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}" wire:ignore>
            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>

        <div class="form-group @if ($jenis != 1) hidden @endif">
           <?php
            $field_name = 'karat.type';
            $field_lable = label_case('Tipe');
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
            <select wire:model="{{ $field_name }}" class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" wire:ignore>
                <option value="" selected disabled>Pilih Tipe</option>
                <option value="LM">Logam Mulia</option>
                <option value="GOLD">Emas</option>
            </select>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>




    </div>
    <div class="pt-2 border-t flex justify-between">
        <div></div>
        <div class="form-group">
            <a class="px-5 btn btn-outline-danger" href="{{ route("karat.index") }}">
                @lang('Cancel')</a>
            <button class="px-5 btn  btn-submit btn-outline-success" wire:click.prevent="store" wire:target="store" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="store">
                    >@lang('Save')
                </span>
                <span wire:loading wire:target="store" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </span>
            </button>
        </div>
    </div>



</form>
@push('page_scripts')
<script type="text/javascript">
    
</script>



@endpush