<div class="px-2 border-l">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form  wire:submit.prevent="store">

<div class="flex gap-1">


{{-- batasss --}}

<div class="w-2/5 p-0 text-center">

  <div x-data="{photoName: null, photoPreview: null}" class="items-center">
    <?php
    $field_name = 'image';
    $field_lable = __($field_name);
    $label = Label_Case($field_lable);
    $field_placeholder = $label;
    $required = '';
    ?>
    <input type="file" wire:model="{{ $field_name }}" accept="image/*" class="hidden" x-ref="photo" x-on:change="
    photoName = $refs.photo.files[0].name;
    const reader = new FileReader();
    reader.onload = (e) => {
    photoPreview = e.target.result;
    };
    reader.readAsDataURL($refs.photo.files[0]);
    ">

    <div class="text-center">
      <div class="mb-1" x-show="! photoPreview">
        <img src="{{ asset('images/logo.png') }}" class="w-40 h-40 m-auto rounded-xl border-dashed border-2">
      </div>
      <div class="py-1" x-show="photoPreview" style="display: none;">
        <span class="block w-40 h-40 rounded-xl m-auto" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
        </span>
      </div>
      <button type="button" class="inline-flex btn btn-sm btn-outline-success" x-on:click.prevent="$refs.photo.click()">
      @lang('Select Image')
      </button>
    </div>
 @error('image') <span class="text-danger">{{ $message }}</span> @enderror
  </div>
</div>
{{-- batasss --}}



   <div class="w-3/5">

     <div class="form-group">

       <select class="form-control form-control-sm" wire:model="get_category">
              <option value="">Pilih Kategori</option>
              @foreach($category as $option)
                  <option value="{{ $option->id }}">{{ $option->category_name }}</option>
              @endforeach
          </select>

            @error('get_category') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <input wire:model="product_name" type="text" class="form-control form-control-sm" id="product_name"
             value="{{ old('product_name') }}" placeholder="Nama Produk">
            @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

         <div class="form-group">
            <input type="text" class="form-control form-control-sm" id="price"
             value="{{ old('price') }}" wire:model="price"
             placeholder="Price"
             type-currency="IDR">
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

             <div class="form-group">
            <input wire:model="sale" type="text" class="form-control form-control-sm"
             id="sale"  value="{{ old('sale') }}"
             placeholder="Produk Sale"
             type-currency="IDR">
            @error('sale') <span class="text-danger">{{ $message }}</span> @enderror
        </div>



   </div>
</div>


<div class="flex justify-between mt-3">
    <div class="text-gray-700 text-center"></div>
    <div class="justify-end py-2">
        <button type="submit" class="px-4 btn-sm btn btn-danger hover:bg-red-300">
        Tambah
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