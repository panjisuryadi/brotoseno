<div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <form wire:submit.prevent="store">
        @csrf

<div class="flex flex-row grid grid-cols-2 gap-1">
     <div class="form-group">
            <?php
            $field_name = 'code';
            $field_lable = __('no_penerimaan_barang');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'readonly';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <input type="text" name="{{ $field_name }}"
            class="form-control {{ $invalid }}"
            name="{{ $field_name }}"
            value="{{ $generateCode }}"
            placeholder="{{ $field_placeholder }}" {{ $required }}>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>



 <div class="form-group">
        <?php
        $field_name = 'no_invoice';
        $field_lable = __('No Surat Jalan / Invoice');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = 'wire:model="'.$field_name.'"';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>

             {{ html()->text($field_name)
                        ->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')
                    ->attributes(["$required"]) }}
                @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>







<div class="form-group">
    <?php
            $field_name = 'supplier_id';
            $field_lable = __('Supplier');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'required';
            ?>
    <label class="mb-0" for="{{ $field_name }}">Supplier</label>
    <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}">
        <option value="">Select Supplier</option>
        @foreach(\Modules\People\Entities\Supplier::all() as $row)
        <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
        {{$row->supplier_name}} </option>
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
       $field_name = 'tanggal';
        $field_lable = __('Tanggal');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = 'wire:model="'.$field_name.'"';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>

             {{ html()->date($field_name)
                        ->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')
                    ->attributes(["$required"]) }}
                @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>




    </div>




        <div class="flex justify-between">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-3 gap-2">
                <div class="form-group">
                    <?php
                            $field_name = 'karat_id.0';
                            $field_lable = __('Parameter Karat');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = 'wire:model="'.$field_name.'"';
                            ?>
                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                    <select class="form-control select2" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                        <option value="" selected disabled>Select Karat</option>
                        @foreach(\Modules\Karat\Models\Karat::all() as $row)
                        <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
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
        $field_name = 'kategori_id.0';
        $field_lable = __('Kategori');
        $field_placeholder = Label_case($field_lable);
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = 'wire:model="'.$field_name.'"';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
        <select class="form-control select2" name="{{ $field_name }}" wire:model="{{ $field_name }}">
            <option value="" selected disabled>Select Kategori</option>
            @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $row)
            <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
            {{$row->name}}  </option>
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
                    $field_name = 'qty.0';
                    $field_lable = label_case('qty');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"  min="0" step="0.001"';
                    ?>
                     <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>






            </div>
            <div class="px-1">
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

            $field_name = 'karat_id.'.$value.'';
            $field_lable = __('Parameter Karat');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'wire:model="'.$field_name.'"';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
            <select class="form-control select2" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                <option value="" selected disabled>Select Karat</option>
                @foreach(\Modules\Karat\Models\Karat::all() as $row)
                <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
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
    $field_name = 'kategori_id.'.$value.'';
    $field_lable = __('Kategori');
    $field_placeholder = Label_case($field_lable);
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = 'wire:model="'.$field_name.'"';
    ?>
    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
    <select class="form-control select2" name="{{ $field_name }}" wire:model="{{ $field_name }}">
        <option value="" selected disabled>Select Kategori</option>
        @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $row)
        <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
        {{$row->name}}  </option>
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
                    $field_name = 'qty.'.$value.'';
                    $field_lable = label_case('qty');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                    {{ html()->number($field_name)
                        ->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')
                    ->attributes(["$required"]) }}
                     @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>


            </div>
            <div class="px-1">
                <button class="btn text-white text-xl btn-danger btn-md" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                <span wire:loading wire:target="remove({{$key}})" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>
        @endforeach


<div class="add-input w-full mx-auto flex flex-row grid grid-cols-3 gap-2">

 <div class="form-group">
        <?php
        $field_name = 'total_emas';
        $field_lable = label_case('total_emas');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = 'min="0" step="0.001" wire:model="'.$field_name.'"';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}
            <span class="text-danger small"> (yg harus dibayar)</span></label>

             {{ html()->number($field_name)
                        ->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')
                    ->attributes(["$required"]) }}
                @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>



<div class="form-group">
    <?php
    $field_name = 'tipe_pembayaran';
    $field_lable = __("Tipe Pembayaran");
    $field_placeholder = __("Pilih Tipe Pembayaran");
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = 'required';
    $attributes = 'wire:model="'.$field_name.'"
    wire:click="changeEvent($event.target.value)"';
    $select_options = [
        'cicil' => 'Cicil',
        'jatuh_tempo' => 'Jatuh Tempo',
        'lunas' => 'Lunas'
    ];
    ?>
    {{ html()->label($field_lable, $field_name)->class('mb-0') }} {!! fielf_required($required) !!}
    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control  '.$invalid.'')->attributes(["$attributes"]) }}
     @if ($errors->has($field_name))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
</div>


@if($tipe_pembayaran == 'cicil')
<div class="form-group">
    <label class="mb-0" for="status">Cicil <span class="text-danger">*</span></label>
    <select class="form-control select2" name="cicilan" id="cicilan">
        <option value="1">1 kali</option>
        <option value="2">2 kali </option>
    </select>
</div>

@elseif($tipe_pembayaran == 'jatuh_tempo')
  <div class="form-group">
            <?php
            $field_name = 'tgl_jatuh_tempo';
            $field_lable = __('Tanggal');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
            <label class="mb-0" for="{{ $field_name }}">
            {{ $field_placeholder }}
           </label>
            <input type="date" name="{{ $field_name }}"
            class="form-control {{ $invalid }}"
            name="{{ $field_name }}"
            value="{{ old($field_name) }}"
            placeholder="{{ $field_placeholder }}" {{ $required }}>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>
@else
<div class="form-group ">
     <label class="mb-0 text-white">...</label>
   <div class="border border-1 text-center uppercase py-2">LUNAS</div>
</div>
@endif



</div>





<div class="flex flex-row grid grid-cols-3 gap-2">

 <div class="form-group">
        <?php
        $field_name = 'berat_kotor';
        $field_lable = label_case('berat_kotor');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = 'wire:model="'.$field_name.'"';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
        @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>


 <div class="form-group">
        <?php
        $field_name = 'berat_real';
        $field_lable = label_case('berat_real');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
         $required = 'wire:model="'.$field_name.'"';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
      @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>


 <div class="form-group">
        <?php
        $field_name = 'selisih';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger small">(Gram)</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="0">
      @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>


</div>


<div class="form-group">
    <?php
    $field_name = 'note';
    $field_lable = __('Catatan');
    $field_placeholder = Label_case($field_lable);
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = '';
    ?>
    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
    <textarea name="{{ $field_name }}"
    placeholder="{{ $field_placeholder }}"
    rows="5"
    id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}" wire:model="{{ $field_name }}"></textarea>
    @if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>



<div class="flex flex-row grid grid-cols-2 gap-2">
 <div class="form-group">
            <?php
            $field_name = 'pengirim';
            $field_lable = __('nama_pengirim');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'wire:model="'.$field_name.'"';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
            {{ html()->text($field_name)
                        ->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control   '.$invalid.'')
                    ->attributes(["$required"]) }}
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>

<div class="form-group">
     <?php
            $field_name = 'user_id';
            $field_lable = __('pic');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
    <label class="mb-0" for="{{ $field_name }}">PIC</label>
   <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}">
        <option value="" selected disabled>Select PIC</option>
        @foreach($kasir as $sup)
         <option value="{{$sup->id}}" {{ old('user_id') == $sup->id ? 'selected' : '' }}>
            {{$sup->name}} |  {{$sup->kode_user}} </option>
        @endforeach
    </select>
   @if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>

{{-- batas --}}
</div>











        <div class="pt-2 border-t flex justify-between">
            <div></div>
            <div class="form-group">
                <a class="px-5 btn btn-danger"
                    href="{{ route("goodsreceipt.index") }}">
                @lang('Cancel')</a>
 <button class="px-5 btn  btn-submit btn-success" wire:click.prevent="store" wire:target="store" wire:loading.attr="disabled">
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
</div>


@push('page_scripts')
<script type="text/javascript">

document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
  element.addEventListener('keyup', function(e) {
    let cursorPostion = this.selectionStart;
    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
    let originalLenght = this.value.length;
    if (isNaN(value)) {
      this.value = "";
    } else {
      this.value = value.toLocaleString('id-ID', {
        currency: 'IDR',
        style: 'currency',
        minimumFractionDigits: 0
      });
      cursorPostion = this.value.length - originalLenght + cursorPostion;
      this.setSelectionRange(cursorPostion, cursorPostion);
    }
  });
});

</script>
<script>
    $(document).ready(function() {
        $('#supplier_id').select2();
        $('#supplier_id').on('change', function (e) {
            var data = $('#supplier_id').select2("val");
            @this.set('supplier_id', data);
        });
    });
</script>
@endpush