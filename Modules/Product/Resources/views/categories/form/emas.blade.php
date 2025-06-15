<div class="grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="product_note">Kategori Emas</label>
        <select class="form-control select2" name="gold_kategori_id" id="gold_kategori_id" required>
            @foreach(\Modules\GoldCategory\Models\GoldCategory::all() as $sup)
            <option value="{{$sup->id}}" {{ old('gold_kategori_id') == $sup->id ? 'selected' : '' }}>
            {{$sup->name}}</option>
            @endforeach
        </select>
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
        min="0" step="0.01"
        wire:model="berat_accessories"
        wire:change="recalculateTotal"
        wire:keyup="recalculateTotal"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}"
        >
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
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
{{-- END BERAT --}}


{{-- HARGA --}}
<div class="flex relative py-1">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Harga</span>
    </div>
</div>
<div class="flex flex-row grid grid-cols-2 gap-2">
    
    <div class="form-group">
        <?php
        $field_name = 'harga_emas';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="small text-danger">&nbsp;(Harga Emas beli per gram)</span></label>
        <input class="form-control numeric"
        type="text"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        wire:model="inputHargaEmas"

        placeholder="{{ $field_placeholder }}"
        >
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    <div class="form-group">
        <?php
        $field_name = 'product_cost';
        $field_lable = label_case('Biaya Produk');
        $field_placeholder =label_case('Harga Emas x Berat');
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}
            <span class="text-danger">*</span></label>
            <input class="form-control"
            type="text"
            name="product_cost_rp"
            id="{{ $field_name }}"
            value="{{ $productCost }}"
            placeholder="{{ $field_placeholder }}"
            readonly>
            <input type="hidden" name="{{ $field_name }}" value="{{ $price }}">
         
            <div class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </div>
        </div>
        
        
    </div>
    <div class="flex flex-row grid grid-cols-2 gap-2">
        
        <div class="form-group">
            <?php
            $field_name = 'margin';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <div class="flex justify-between py-0 px-0">
                
                <div>
                    <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                </div>
                
          <div class="py-0">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault"
                id="flexRadioDefault1" wire:click="tipeMargin('gram')">
                <label class="form-check-label" for="gram">Gram</label>
            </div> 

             <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault"
                id="flexRadioDefault1" wire:click="tipeMargin('nominal')" checked>
                <label class="form-check-label" for="nominal">Nominal</label>
            </div> 

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2"  wire:click="tipeMargin('persentase')">
                <label class="form-check-label" for="margin">Persentase</label>
            </div>
            
           </div>


            </div>

        @if($tipeMarginGram == 'gram')
         <input class="form-control numeric"
                type="number"
                id="{{ $field_name }}"
                wire:model="margin_gram"
                min="1" max="100" step="1"
                wire:keyup="calculateMarginGram"
                placeholder="Margin Gram"
                >
        @elseif($tipeMarginGram == 'nominal')
           <input class="form-control numeric"
                type="number"
                id="{{ $field_name }}"
                wire:model="margin_nominal"
                min="1" max="100" step="1"
                wire:keyup="calculateMarginNominal"
                placeholder="Margin Nominal"
                >
        @elseif($tipeMarginGram == 'persentase')
          <input class="form-control numeric"
                type="number"
                id="{{ $field_name }}"
                wire:model="margin_persentase"
                min="1" max="100" step="1"
                wire:keyup="calculateMarginPersentase"
                placeholder="Margin Persentase"
                >
        @else
          <input class="form-control numeric"
                type="number"
                id="{{ $field_name }}"
                wire:model="margin_nominal"
                min="1" max="100" step="1"
                wire:keyup="calculateMarginNominal"
                placeholder="Margin Nominal"
                >
        @endif
  
            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
        </div>
        <div class="form-group">
            <?php
            $field_name = 'product_price';
            $field_lable = label_case('Harga Jual');
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}
                <span class="small text-danger">Product cost + margin</span>
            </label>
            <input class="form-control"
            type="text"
            name="{{ $field_name }}"
            id="{{ $field_name }}"
            value="{{$produkPriceResult}}"
            placeholder="{{ $field_placeholder }}"
            readonly>
            <input type="hidden" name="{{ $field_name }}" value="{{ $grandtotal }}">
            <span id="grand_total" class="text-lg text-danger"></span>
            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
        </div>
        
        
    </div>
    <div class="flex flex-row grid grid-cols-1 gap-2">
        <div class="flex justify-end px-2 py-4">
            <div></div>
            <div>
                <div class="font-semibold text-gray-500  leading-5 text-xs">
                    Biaya Produk: {{ $productCost }}
                </div>
                <div class="font-semibold text-gray-500 leading-5  text-xs">Harga : {{ $produkPriceResult }}</div>
            </div>
        </div>
    </div>
    {{-- HARGA --}}


    @push('page_scripts')

<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {

$(document).ready(function() {
    $('.numeric').keypress(function(e) {
            var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
            if (verified) {e.preventDefault();}
    });
});


$("#qty_diterima").on('input', function() {
  if ($('#qty_diterima').val() > $('#qty').val()) {
      var bla = $('#qty').val();
     $("#qty_diterima").val(bla);
    return false;
  }
});


$('#FormTambah').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});


})(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush