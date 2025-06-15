<div>
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
           
        <div class="flex justify-between">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-3 gap-2">
       
            <div class="form-group">
                <?php
                        $field_name = 'inputs[0]karat_id';
                        $field_lable = __('Parameter Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                <select class="form-control" name="karat_id[]">
                    <option value="" selected disabled>Select Karat</option>
                    @foreach(\Modules\Karat\Models\Karat::all() as $row)
                    <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
                    {{$row->name}} | {{$row->kode}} </option>
                    @endforeach
                </select>
                  @if ($errors->has($field_name))
                        <span class="invalid feedback"role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                            class="text-danger">
                        </span>
                        @endif
                </div>


        <div class="form-group">
                <?php
                    $field_name = 'inputs[0]kategori_id';
                    $field_lable = __('Kategori');
                    $field_placeholder = Label_case($field_lable);
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
            <select class="form-control" name="kategori_id[]">
                <option value="" selected disabled>Select Category</option>
                @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $row)
                <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
                {{$row->name}} </option>
                @endforeach
             </select>
               @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
              </div>


            <div class="form-group">
                    <?php
                    $field_name = 'inputs[0]qty';
                    $field_lable = label_case('qty');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                 <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
               <input class="form-control"
               type="number"
                name="qty[]"
                id="{{ $field_name }}"

                placeholder="Qty">
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>



            </div>
            <div class="px-1 py-4">
                <button class="btn text-white text-xl btn-info btn-md" wire:click.prevent="add({{$i}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                <span wire:loading wire:target="add" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>
        @foreach($inputs as $key => $value)
        <div class="flex justify-between">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-3 gap-2">
       
             <div class="form-group">
                    <?php
                        $field_name = 'inputs['.$value.']karat_id';
                        $field_lable = __('Parameter Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                    <select class="form-control" name="karat_id[]">
                    <option value="" selected disabled>Select Karat</option>
                    @foreach(\Modules\Karat\Models\Karat::all() as $row)
                    <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
                    {{$row->name}} | {{$row->kode}} </option>
                    @endforeach
                </select>
                  @if ($errors->has($field_name))
                        <span class="invalid feedback"role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                            class="text-danger">
                        </span>
                        @endif
                </div>


        <div class="form-group">
        <?php
            $field_name = 'inputs['.$value.']kategori_id';
            $field_lable = __('Kategori');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'wire:model="'.$field_name.'"';
            ?>
   
    <select class="form-control" name="kategori_id[]">
        <option value="" selected disabled>Select Category</option>
        @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $row)
        <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
        {{$row->name}} </option>
        @endforeach
    </select>
       @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
      </div>

      <div class="form-group">
                <?php

                $field_name = 'inputs['.$value.']qty';
                $field_name = 'qty.'.$value.'';
                $field_lable = label_case('qty');
                $field_placeholder = $field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = '';
                ?>
               <input class="form-control" type="number"
                name="qty[]"
                id="{{ $field_name }}"
                wire:model={{ $field_name }}
                placeholder="Qty">
                 @if ($errors->has($field_name))
                <span class="invalid feedback"role="alert">
                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                    class="text-danger">
                </span>
                @endif
            </div>

            </div>
              <div class="px-1">
                <button class="btn text-white text-xl btn-danger btn-xs" 
                wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                <span wire:loading wire:target="remove({{$key}})" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>
        @endforeach




</div>


@push('page_scripts')


@endpush