@extends('layouts.app')
@section('title', 'Create GoodsReceipt')


@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("goodsreceipt.index") }}">GoodsReceipt</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection

@section('content')
@push('page_css')

<style type="text/css">
    .dropzone {
        height: 280px !important;
        min-height: 190px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
    }
    .dropzone i.bi.bi-cloud-arrow-up {
        font-size: 5rem;
        color: #bd4019 !important;
    }

</style>
@endpush
<div class="container-fluid">
<script src="{{  asset('js/jquery.min.js') }}"></script>
    <form action="{{ route('goodsreceipt.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="flex relative py-3">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-b border-gray-300"></div>
                    </div>


                    <div class="relative flex justify-left">
                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Goods Receipts')}} <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Goods Receipts')}}"></i>
                        </span>


                    </div>


 <a class="flex" href="{{ route('goodsreceipt.index') }}">
    <div class="absolute bottom-7 right-0 flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
        <i class="bi bi-house text-gray-600"></i>
    </div>
 </a>


                </div>

<div class="flex flex-row grid grid-cols-3 gap-2">

<div class="px-0 py-2">
    <div class="form-group">
        <div class="py-1">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                <label class="form-check-label" for="up2">Upload</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="upload"
                id="up1">
                <label class="form-check-label" for="up1">Webcam</label>
            </div>
        </div>
        <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center">
            <x-library.webcam />
        </div>
        <div id="upload1">
            <div class="form-group">

                <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                    <div class="dz-message" data-dz-message>
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-span-2 px-2">
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
            value="{{ $code }}"
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
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <input type="text" name="{{ $field_name }}"
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


<div class="form-group">
    <?php
            $field_name = 'supplier_id';
            $field_lable = __('Supplier');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
    <label class="mb-0" for="{{ $field_name }}">Supplier</label>
    <select class="form-control select2" name="{{ $field_name }}">
        <option value="" selected disabled>Select Supplier</option>
        @foreach(\Modules\People\Entities\Supplier::all() as $row)
        <option value="{{$row->id}}" {{ old('supplier_id') == $row->id ? 'selected' : '' }}>
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
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
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


    </div>

<livewire:goods-receipt.penerimaan/>

{{-- <div class="flex flex-row grid grid-cols-3 gap-2">
    
<div class="form-group">
    <?php
            $field_name = 'karat_id';
            $field_lable = __('Parameter Karat');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
    <select class="form-control select2" name="{{ $field_name }}">
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
            $field_name = 'kategoriproduk_id';
            $field_lable = __('Kategori');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
    <select class="form-control select2" name="{{ $field_name }}">
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
        $field_name = 'qty';
        $field_lable = label_case('Qty');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


</div> --}}



<div class="flex flex-row grid grid-cols-2 gap-2">

<div class="flex grid grid-cols-2 gap-2">


 <div class="form-group">
        <?php
        $field_name = 'total_emas';
        $field_lable = label_case('total_emas');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
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
    <select  class="form-control" name="tipe_pembayaran" id="tipe_pembayaran">
        <option value="cicil">Cicil</option>
        <option value="jatuh_tempo">Jatuh Tempo</option>
        <option value="lunas">Lunas</option>
    </select>
</div>   


{{-- select cicil = show input (1,2.3 kali) tipe select option ,1/3 kali --}}

{{-- select jatuh tempo =  pilih tanggal =tipe date  --}}

{{-- Lunas = do nothing --}}
</div>

 


<div id="cicilan" class="form-group">
    <label class="mb-0" for="status">Cicil <span class="text-danger">*</span></label>
    <select class="form-control select2" name="cicilan" id="cicilan">
        <option value="1">1 kali</option>
        <option value="2">2 kali </option>
    </select>
</div>



  <div id="tgl_jatuh_tempo" class="form-group d-none">
            <?php
            $field_name = 'tgl_jatuh_tempo';
            $field_lable = __('Tanggal');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
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



</div>


<div class="flex flex-row grid grid-cols-3 gap-2">
    
 <div class="form-group">
        <?php
        $field_name = 'berat_kotor';
        $field_lable = label_case('berat_kotor');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


 <div class="form-group">
        <?php
        $field_name = 'berat_real';
        $field_lable = label_case('berat_real');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
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
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
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
    id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}"></textarea>
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
            $required = '';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <input type="text" name="{{ $field_name }}"
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






</div>


{{-- batas --}}




</div>



  <div class="mt-4 flex justify-between">
                            <div></div>
                            <div class="form-group">
                             <a class="px-5 btn btn-danger"
                            href="{{ route("goodsreceipt.index") }}">
                            @lang('Cancel')</a>
                                <button type="submit" class="px-5 btn btn-success">@lang('Save')  <i class="bi bi-check"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
<x-library.select2 />
<x-toastr />
@section('third_party_scripts')
<script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
@push('page_scripts')
<script>
    var uploadedDocumentMap = {}
    Dropzone.options.documentDropzone = {
        url: '{{ route('dropzone.upload') }}',
        maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, .png',
        maxFiles: 3,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
        },
        removedfile: function (file) {
            file.previewElement.remove();
            var name = '';
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name;
            } else {
                name = uploadedDocumentMap[file.name];
            }
            $.ajax({
                type: "POST",
                url: "{{ route('dropzone.delete') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'file_name': `${name}`
                },
            });
            $('form').find('input[name="document[]"][value="' + name + '"]').remove();
        },
        init: function () {
            @if(isset($product) && $product->getMedia('pembelian'))
            var files = {!! json_encode($product->getMedia('pembelian')) !!};
            for (var i in files) {
                var file = files[i];
                this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, file.original_url);
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
            }
            @endif
        }
    }
</script>

@endpush

@push('page_scripts')

<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {

    $('#up1').change(function() {
        $('#upload2').toggle();
        $('#upload1').hide();
    });
    $('#up2').change(function() {
        $('#upload1').toggle();
        $('#upload2').hide();
    });

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




$(document).ready(function(){
    $('#tipe_pembayaran').on('change', function() {
     if($( "option:selected", this ).val()=="jatuh_tempo"){
       $("#tgl_jatuh_tempo").removeClass('d-none');
       $("#cicilan").addClass('d-none');
    }else if($( "option:selected", this ).val()=="lunas"){
          $("#cicilan").addClass('d-none');
          $("#tgl_jatuh_tempo").addClass('d-none');
         // $("#cicil").removeClass('d-none');
         // $('select[name="cicil"]').attr('disabled', 'disabled');
 
    }else{
        $("#tgl_jatuh_tempo").addClass('d-none');
        $("#cicilan").removeClass('d-none');
    }
   
    });
});


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

})(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush


