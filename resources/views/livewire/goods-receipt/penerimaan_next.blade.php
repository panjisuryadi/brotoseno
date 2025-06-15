<div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <form wire:submit.prevent="store">
        @csrf
        <div class="flex justify-between">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-2 gap-2">
                <div class="form-group">
                    <?php
                    $field_name = 'no_invoice.0';
                    $field_lable = label_case('no_invoice');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
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


  
                 <div class="form-group">
                    <?php
                    $field_name = 'qty.0';
                    $field_lable = label_case('qty');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
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
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-2 gap-2">
                <div class="form-group">
                    <?php
                    $field_name = 'no_invoice.'.$value.'';
                    $field_lable = label_case('no_invoice');
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
        $required = 'wire:model="'.$field_name.'"';
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}
            <span class="text-danger small"> (yg harus dibayar)</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
         min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
           @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>



<div class="form-group">
    <label class="mb-0" for="tipe_pembayaran">Tipe Pembayaran <span class="text-danger">*</span></label>
    <select  class="form-control"
     name="tipe_pembayaran" 
     id="tipe_pembayaran" wire:click="changeEvent($event.target.value)">
        <option value="cicil">Cicil</option>
        <option value="jatuh_tempo">Jatuh Tempo</option>
        <option value="lunas">Lunas</option>
    </select>
</div>   

@if($pilih_tipe_pembayaran == 'cicil')
<div class="form-group">
    <label class="mb-0" for="status">Cicil <span class="text-danger">*</span></label>
    <select class="form-control select2" name="cicilan" id="cicilan">
        <option value="1">1 kali</option>
        <option value="2">2 kali </option>
    </select>
</div>

@elseif($pilih_tipe_pembayaran == 'jatuh_tempo')
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
<div class="form-group py-2">
   <span>LUNAS</span>
</div>
@endif



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

@endpush