<div>
     <form wire:submit.prevent="store">
    <div class="flex justify-between py-1 border-bottom">
        
        <div class="form-group mb-0 w-1/4">
            <label class="mb-0" for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
            <select class="form-control form-control-sm select2" 
            wire.model="karat_id" 
            wire:change="pilihKarat($event.target.value)" 
            name="karat_id" id="karat_id" required>
                <option value=""> Pilih Karat</option>

                @foreach(\Modules\Karat\Models\Karat::whereNull('parent_id')->get() as $jp)
                <option value="{{ $jp->id }}">{{ $jp->name }} | {{ $jp->kode }}</option>
                @endforeach
            </select>
           @if ($errors->has('karat_id'))
                <div class="invalid feedback"role="alert">
                    <small class="text-danger">{{ $errors->first('karat_id') }}.</small
                        class="text-danger">
                </div>
            @endif

        </div>
        
      

<div id="buttons" class="flex flex-row">
<a class="flex" title="Master Data Karat" href="{{ route("karat.index") }}">
    <div class="flex h-8 w-8 items-center justify-center p-2 mr-1 rounded-full border border-muted bg-muted">
        <i class="bi bi-card-list text-gray-600"></i>
    </div>
 </a>


<a class="flex" title="Kembali ke Iventory" href="{{ route("iventory.index") }}">
    <div class="flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
        <i class="bi bi-house text-gray-600"></i>
    </div>
 </a>


</div>



      
    </div>
   


<div class="px-3">
       @if($updateMode)
      
<h1 class="py-3 font-semibold text-blue-600">{{$penentuan_harga->karat->name}}</h1>
       @else
        <h1 class="py-3 font-semibold text-gray-400">Data Kosong</h1>


       @endif

</div>



<table class="table table-striped">
    <thead>
        <tr>
         
            <th style="width: 10%;" class="text-left">Karat</th>
            <th class="text-left">Harga Emas</th>
            <th class="text-left">Harga Modal</th>
            <th class="text-left">Margin</th>
            <th class="text-left">Harga Jual</th>
        </tr>
    </thead>
    <tbody>
        <tr>

            <td style="width: 15%;" class="text-center">
                 <input type="hidden" 
                       name="karat_id" 
                       value="{{$karat_id}}" 
                       wire.model="karat_id" 
                       >
                <input type="text" 
                wire.model="karat" class="form-control text-center" 
                name="karat" value="{{$kode_karat}}" >
            </td>
            <td style="width: 24%;" class="text-left">
               
       <div class="form-group">
        <?php
        $field_name = 'harga_emas';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <input class="form-control"
        type="text"
        wire:model="harga_emas"
        wire:change="setHargaModal($event.target.value)"
        type-currency="IDR"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        
           @if($errors->has('harga_emas'))
                <div class="invalid feedback"role="alert">
                    <small class="text-danger">{{ $errors->first('harga_emas') }}.</small
                        class="text-danger">
                </div>
            @endif
    </div>
    



            </td>
            <td  style="width: 20%;" class="text-left">
           
  <div class="form-group">
        <?php
        $field_name = 'harga_modal';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <input class="form-control numeric"
        type="text"
        type-currency="IDR"
        name="{{ $field_name }}"
        wire:model="harga_modal"
        {{-- wire:change="recalculateTotal"
        wire:keyup="recalculateTotal" --}}
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}" readonly>
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


        </td>


          <td  style="width: 20%;" class="text-left">
       <div class="form-group">
        <?php
        $field_name = 'harga_margin';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <input class="form-control numeric"
        type="text"
        type-currency="IDR"
        name="{{ $field_name }}"
        wire:model="harga_margin"
        wire:change="setHargaJual($event.target.value)"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
     
           @if($errors->has('harga_margin'))
                <div class="invalid feedback"role="alert">
                    <small class="text-danger">{{ $errors->first('harga_margin') }}.</small
                        class="text-danger">
                </div>
            @endif
    </div>


            </td>



           <td style="width: 23%;" class="text-left">
                <input 
                type="text" 
                value="{{$harga_jual}}" 
                class="form-control" 
                 readonly>  

                 <input 
                type="hidden" 
                wire.model="harga_jual" 
                value="{{$harga_jual}}" 
                class="form-control" 
                name="harga_jual">


            </td>
       
        </tr>
      
    </tbody>
</table>





<div class="flex justify-between px-3 pb-2 border-bottom">
    <div>
    </div>
    <div class="form-group">
        <a class="px-5 btn btn-outline-danger"
            href="{{ route("iventory.index") }}">
        @lang('Cancel')</a>
        <button id="SimpanTambah" type="submit" class="px-4 btn btn-outline-success">
        @lang('Save')  <i class="bi bi-check"></i></button>
    </div>
</div>





</form>






</form>






</form>

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
















</div>