<div>
    <div>
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        <form wire:submit.prevent="store">
            @csrf

            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">

                </div>
                


                <div class="w-2/4">
                    <!-- No retur -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">No. Retur</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <input wire:model="retur_sales.retur_no" type="text" name="retur_no" id="retur_no" placeholder="Nomor Retur" class="form-control @error('retur_sales.retur_no') is-invalid @enderror" readonly>
                            @error('retur_sales.retur_no')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>


                    <!-- Date -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide"> Date</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <input wire:model="retur_sales.date" type="date" min="{{$hari_ini}}" name="retur" id="date" class="form-control @error('retur_sales.date') is-invalid @enderror">
                            @error('retur_sales.date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sales -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Dari</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <select class="form-control select2 @error('retur_sales.sales_id') is-invalid @enderror" name="sales_id" wire:model="retur_sales.sales_id">
                                <option value="" selected disabled>Pilih Sales</option>
                                @foreach($dataSales as $sales)
                                <option value="{{$sales->id}}">
                                    {{$sales->name}}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('retur_sales.sales_id'))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first('retur_sales.sales_id') }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

            @foreach($retur_sales_detail as $key => $value)
            <div class="flex justify-between mb-3">
                <div class="add-input w-full mx-auto flex flex-row grid grid-cols-4 gap-2">


                    <div class="form-group">
                        <?php

                        $field_name = 'retur_sales_detail.' . $key . '.karat_id';
                        $field_lable = __('Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        @if ($key == 0)
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>
                        @endif
                        <select class="form-control form-control-sm @error($field_name) is-invalid @enderror" wire:model="retur_sales_detail.{{$key}}.karat_id" name="{{ $field_name }}">
                            <option value="" selected>Pilih Karat</option>
                            @foreach($dataKarat as $karat)
                            <option value="{{$karat->id}}">
                                {{ $karat->label }}
                            </option>
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

                        $field_name = 'retur_sales_detail.' . $key . '.weight';
                        $field_lable = label_case('Berat Asal');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:change=weightUpdated('.$key.') wire:model.debounce.1s="' . $field_name . '"';
                        ?>
                        @if ($key == 0)
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>
                        @endif
                        {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required","min=0","step=0.001"]) }}
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <?php

                        $field_name = 'retur_sales_detail.' . $key . '.nominal';
                        $field_lable = label_case('harga (%)');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:change=hargaUpdated('.$key.') wire:model.debounce.1s="' . $field_name . '"';
                        ?>
                        @if ($key == 0)
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}</label>
                        @endif
                        {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required","min=0"]) }}
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <?php

                        $field_name = 'retur_sales_detail.' . $key . '.pure_gold';
                        $field_lable = label_case('24K');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model.debounce.1s="' . $field_name . '"';
                        ?>
                        @if ($key == 0)
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>
                        @endif
                        {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required","min=0","step=0.001","readonly"]) }}
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>





                </div>
                @if ($key == 0)
                <div class="px-1 pt-4">
                    <button class="btn text-white text-xl btn-info btn-sm" wire:click.prevent="add" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                    <span wire:loading wire:target="add" class="text-center">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </span>
                    </button>
                </div>
                @else
                <div class="px-1 pt-1">
                    <button class="btn text-white text-xl btn-danger btn-sm" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                        <span wire:loading wire:target="remove({{$key}})" class="text-center">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
                @endif
            </div>
            @endforeach





            <div class="flex flex-col items-end mb-8">
                    <div class="mb-2 md:mb-1 flex items-center">
                        <label class="w-30 text-gray-700 block text-sm tracking-wide">Total Berat Asal</label>
                        <span class="mr-4 md:block">:</span>
                        <div class="flex-1">
                            <input class="form-control form-control-sm" wire:model.debounce.1s="retur_sales.total_weight" type="text" placeholder="0" readonly>
                        </div>
                    </div>

            </div>






    </div>




    <div class="pt-2 border-t flex justify-between">
        <div></div>
        <div class="form-group">
            <a class="px-5 btn btn-outline-danger" href="{{ route("goodsreceipt.index") }}">
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
<div class="pt-2 border-t flex justify-between text-black">
    <p>Catatan : Pilih Sales Terlebih dahulu</p>
</div>
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