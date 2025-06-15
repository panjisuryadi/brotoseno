@extends('layouts.app')
@section('title', $module_title)
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("penerimaanbarangluarsale.index") }}">{{ $module_title }}</a></li>
    <li class="breadcrumb-item active">{{ __('Add') }}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('penerimaanbarangluarsale.store') }}" method="POST">
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
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Penerimaan Barang Luar Sales')}} &nbsp;<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Penerimaan Barang Luar Sales')}}"></i>
        </span>
    </div>
</div>


<div class="flex flex-row grid grid-cols-2 gap-2">
    
     <div class="form-group">
            <?php
            $field_name = 'no_barang_luar';
            $field_lable = __('no_barang_luar');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
            <label for="{{ $field_name }}">{{ $field_placeholder }}<span class="text-danger">*</span></label>
            <input id="{{ $field_name }}" type="text" name="{{ $field_name }}"
            class="form-control {{ $invalid }}"
            name="{{ $field_name }}"
            placeholder="{{ $field_placeholder }}" {{ $required }} readonly>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>

  <div class="form-group">
            <?php
            $field_name = 'date';
            $field_lable = __('Tanggal');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'required';
            ?>
            @php
                $hari_ini = now()->format('Y-m-d');
            @endphp
            <label for="{{ $field_name }}">{{ $field_placeholder }}<span class="text-danger">*</span></label>
            <input type="date" name="{{ $field_name }}"
            class="form-control {{ $invalid }}"
            name="{{ $field_name }}"
            value="{{ $hari_ini }}"
            placeholder="{{ $field_placeholder }}" {{ $required }} max="{{$hari_ini}}">
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>

</div>


<div class="flex flex-row grid grid-cols-2 gap-2">
<div class="form-group">
            <?php
            $field_name = 'customer_sales_id';
            $field_lable = __('customer sales');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
        <label for="{{ $field_name }}" style="margin-bottom: 0.2rem;">Customer Sales <span class="text-danger">*</span></label>
        <select class="form-control select2 {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" >
            <option value="" selected disabled>Pilih Customer Sales</option>
            @foreach(\Modules\CustomerSales\Entities\CustomerSales::all() as $cust)
            <option value="{{ $cust->id }}" {{ old($field_name) == $cust->id ? 'selected' : '' }}>{{ $cust->customer_name }}</option>
            @endforeach
        </select>
        @if ($errors->has($field_name))
        <p class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </p>
        @endif
</div>
<div class="form-group">
    <div>
            <?php
            $field_name = 'sales_id';
            $field_lable = __('sales');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
        <label for="{{ $field_name }}" style="margin-bottom: 0.2rem;">Sales <span class="text-danger">*</span></label>
        <select class="form-control select2 {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" >
            <option value="" selected disabled>Pilih Sales</option>
            @foreach(\Modules\DataSale\Models\DataSale::all() as $sale)
            <option value="{{ $sale->id }}" {{ old($field_name) == $sale->id ? 'selected' : '' }}>{{ $sale->name }}</option>
            @endforeach
        </select>
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>
</div>

</div>


<div class="flex flex-row grid grid-cols-3 gap-2"> 

 <div class="form-group">
        <?php
        $field_name = 'nama_product';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control {{ $invalid }}"
        type="text"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback" role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>
 <div class="form-group">
        <?php
        $field_name = 'kadar';
        $field_lable = label_case('karat');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <select class="form-control select2 {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" >
            <option value="" selected disabled>Pilih Karat</option>
            @foreach(\Modules\Karat\Models\Karat::karat()->get() as $karat)
            <option value="{{ $karat->id }}">{{ $karat->label }}</option>
            @if (count($karat->children))
                @foreach ($karat->children as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->label }}</option>
                @endforeach
            @endif
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
        $field_name = 'berat';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control {{ $invalid }}"
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


</div>





<div class="flex flex-row grid grid-cols-3 gap-2"> 


 <div class="form-group">
        <?php
        $field_name = 'nilai_angkat';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <span class="font-bold ml-3" id="{{ $field_name }}_text"></span>
        <input class="form-control {{ $invalid }}"
        type="number"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        min="0"
        placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>

     <div class="form-group">
        <?php
        $field_name = 'nilai_tafsir';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <span class="font-bold ml-3" id="{{ $field_name }}_text"></span>
        <input class="form-control {{ $invalid }}"
        type="number"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        min="0"
        placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>
 <div class="form-group">
        <?php
        $field_name = 'nilai_selisih';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <span class="font-bold ml-3" id="{{ $field_name }}_text"></span>
        <input class="form-control {{ $invalid }}"
        type="number"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}" readonly>
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
    $field_lable = __('Keterangan');
    $field_placeholder = Label_case($field_lable);
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = '';
    ?>
    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
    <textarea name="{{ $field_name }}"
    placeholder="{{ $field_placeholder }}"
    value="{{ old($field_name) }}"
    rows="5"
    id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}"></textarea>
    @if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>



                        <div class="flex justify-between">
                            <div></div>
                            <div class="form-group">
                             <a class="px-5 btn btn-danger"
                            href="{{ route("buysback.index") }}">
                            @lang('Cancel')</a>
                                <button type="submit" class="px-5 btn btn-success">@lang('Create')  <i class="bi bi-check"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('page_scripts')
<script src="{{  asset('js/jquery.min.js') }}"></script>
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

    function unmaskedCurrency(input){
        return input.replace(/[^0-9]/g, "");
    }

    function calculateSelisih(){
        if($('#nilai_angkat').val() && $('#nilai_tafsir').val()){
            $('#nilai_selisih').val($('#nilai_tafsir').val() - $('#nilai_angkat').val())
            $('#nilai_selisih_text').html('Rp. '+Number($('#nilai_selisih').val()).toLocaleString())
        }
    }

    $('#nilai_angkat').on('keyup', function () {
        $('#nilai_angkat_text').html('Rp. '+Number($(this).val()).toLocaleString())
        calculateSelisih()
    });
    $('#nilai_tafsir').on('keyup', function () {
        $('#nilai_tafsir_text').html('Rp. '+Number($(this).val()).toLocaleString())
        calculateSelisih()
    });

    $(document).ready(function(){
        $.ajax({
            type: "GET",
            url: "{{route('penerimaanbarangluarsale.generate-invoice')}}",
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $('#no_barang_luar').val(data.data);
            }
        })
    });
</script>
@endpush