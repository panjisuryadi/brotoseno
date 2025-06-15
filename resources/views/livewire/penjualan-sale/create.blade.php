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
                    <!-- No Invoice -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Invoice No.</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <input readonly wire:model="penjualan_sales.invoice_no" type="text" name="invoice" id="first_name" placeholder="eg. #INV-100001" class="form-control @error('penjualan_sales.invoice_no') is-invalid @enderror">
                            @error('penjualan_sales.invoice_no')
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
                            <input wire:model="penjualan_sales.date" max="{{ $hari_ini }}" type="date" name="invoice" id="date" class="form-control @error('penjualan_sales.date') is-invalid @enderror">
                            @error('penjualan_sales.date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sales -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <?php
                        $field_name = 'penjualan_sales.sales_id';
                        $field_lable = __('Sales');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Sales</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <select class="form-control select2" wire:model="{{ $field_name }}" wire:change="updateKaratList">
                                <option value="" selected disabled>Pilih Sales</option>
                                @foreach($dataSales as $sales)
                                <option value="{{$sales->id}}">
                                    {{$sales->name}}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Konsumen Sales -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <?php
                        $field_name = 'penjualan_sales.konsumen_sales_id';
                        $field_lable = __('Konsumen Sales');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Konsumen Sales</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <select class="form-control select2" wire:model="penjualan_sales.konsumen_sales_id" wire:change="updateMarketName()">
                                <option value="" selected disabled>Pilih Konsumen</option>
                                @foreach($konsumenSales as $konsumen)
                                <option value="{{$konsumen->id}}">
                                    {{$konsumen->customer_name}}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Store Name -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Nama Pasar</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <input wire:model="penjualan_sales.store_name" type="text" name="store_name" id="store_name" placeholder="" class="form-control @error('penjualan_sales.store_name') is-invalid @enderror" readonly>
                            @error('penjualan_sales.store_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            @foreach($penjualan_sales_details as $key => $value)
            <div class="flex justify-between mb-1">
                <div class="add-input w-full mx-auto flex flex-row grid grid-cols-5 gap-2">

                    <div class="form-group">
                        <?php
                        $field_name = 'penjualan_sales_details.' . $key . '.karat_id';
                        $field_lable = __('Parameter Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm" wire:model="penjualan_sales_details.{{$key}}.karat_id" name="{{ $field_name }}" wire:change="changeParentKarat({{$key}})">
                            <option value="" selected disabled>Select Karat</option>
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

                    <!-- Sub Karat -->
                    {{-- <div class="form-group">
                        @php
                        $field_name = 'penjualan_sales_details.' . $key . '.sub_karat_id';
                        $field_lable = __('Kategori Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        @endphp
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        <select  class="form-control form-control-sm" 
                        name="{{ $field_name }}" wire:model="{{$field_name}}">
                            <option value="" selected disabled>Select Kategori</option>
                            @foreach($penjualan_sales_details[$key]['sub_karat_choice'] as $karat)
                            <option value="{{$karat['id']}}">
                            {{$karat['name']}} | {{$karat['kode']}} </option>
                            @endforeach
                        </select>
                        @if ($errors->has($field_name))
                        <span class="invalid feedback"role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                            class="text-danger">
                        </span>
                        @endif
                    </div> --}}

                    {{-- <div class="form-group">
                        @php
                        $field_name = 'penjualan_sales_details.' . $key . '.type';
                        $field_lable = label_case('type');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        @endphp
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>

                        <select class="form-control form-control-sm" wire:model="{{ $field_name }}" name="{{ $field_name }}" wire:change="setSetoran({{ $key }})">
                            <option value="" selected >Select Type</option>
                            <option value="1"> Setor Uang</option>
                            <option value="2"> Setor Emas</option>
                        </select>
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div> --}}
                    
                    {{-- @if(!empty($penjualan_sales_details[$key]['type']) && $penjualan_sales_details[$key]['type'] == 1) --}}
                        {{-- <div class="form-group">
                            @php
                            $field_name = 'penjualan_sales_details.' . $key . '.nominal';
                            $field_lable = label_case('Nominal');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : ''; 
                            @endphp
                            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                                {{ $field_lable }}</label>
                            </span>
                            <input type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm {{$invalid}}" required min="0" wire:model="{{ $field_name }}"  wire:change="clearNominal({{$key}})" >
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            @php
                            $field_name = 'penjualan_sales_details.' . $key . '.gold_price';
                            $field_lable = label_case('Harga Emas');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : ''; 
                            @endphp
                            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                                {{ $field_lable }}</label>
                            <input type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm {{$invalid}}" required min="0" wire:model = "{{ $field_name }}" wire:change="setJumlah({{$key}})" >
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div> --}}
                    {{-- @endif --}}

                    {{-- @if(!empty($penjualan_sales_details[$key]['type']) && $penjualan_sales_details[$key]['type'] == 2) --}}
                        {{-- <div class="form-group">
                            @php
                            $field_name = 'penjualan_sales_details.' . $key . '.gold_type';
                            $field_lable = label_case('Status');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            @endphp
                            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                                {{ $field_lable }}<span class="text-danger">*</span></label>

                            <select class="form-control form-control-sm" wire:model="{{ $field_name }}" name="{{ $field_name }}">
                                <option value="" selected >Status</option>
                                <option value="lantakan"> Setor Lantakan</option>
                                <option value="rongsok"> Setor Rongsok</option>
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div> --}}

                        <div class="form-group">
                            <?php
                            $field_name = 'penjualan_sales_details.' . $key . '.weight';
                            $field_lable = label_case('Berat');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            ?>
                            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                                {{ $field_lable }}<span class="text-danger">*</span></label>
                            <input type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm {{$invalid}}" required min="0" step="0.001" wire:model ="{{ $field_name }}"  wire:change="setKonversiBerat({{ $key }})">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            @php
                            $field_name = 'penjualan_sales_details.' . $key . '.harga';
                            $field_lable = label_case('Harga %');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $disabled = ($key != 0 ? 'disabled' : '')
                            @endphp

                            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                                {{ $field_lable }}</label>

                            <span class="ml-2">
                                <input type="radio" wire:model="penjualan_sales_details.{{$key}}.harga_type" value="persen" wire:change="clearHarga({{$key}})" {{ $disabled }}>
                                <label class="text-black mb-0">%</label>
        
                                <input type="radio" wire:model="penjualan_sales_details.{{$key}}.harga_type" value="nominal" wire:change="clearHarga({{$key}})" {{ $disabled }}>
                                <label class="text-black mb-0">Rp.</label>
                            </span>
                            {{-- <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                                {{ $field_lable }}<span class="text-danger">*</span></label> --}}
                            @if($penjualan_sales_details[$key]['harga_type'] == 'persen')
                                <input wire:change="setKonversiBerat({{ $key }})" wire:model = "{{ $field_name }}" type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm {{$invalid}}" required min="0" >
                            @else
                                <input  wire:change="setNominal({{$key}})" type="number" placeholder="Harga emas" class="form-control form-control-sm {{$invalid}}" required min="0" name="penjualan_sales_details.{{$key}}.gold_price" wire:model = "penjualan_sales_details.{{$key}}.gold_price">
                            @endif
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    {{-- @endif --}}
                    @if($penjualan_sales_details[$key]['harga_type'] == 'persen')
                        <div class="form-group">
                            <?php
                            $field_name = 'penjualan_sales_details.' . $key . '.jumlah';
                            $field_lable = __('Konversi 24K');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            ?>
                            <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                            <input type="number" name="{{ $field_name }}" class="form-control form-control-sm {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" readonly wire:change="setTotal()">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    @else
                        <div class="form-group">
                            @php
                            $field_name = 'penjualan_sales_details.' . $key . '.nominal';
                            $field_lable = label_case('Total Harga');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : ''; 
                            @endphp
                            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                                {{ $field_lable }}</label>
                            </span>
                            <input readonly type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm {{$invalid}}" required min="0" wire:model="{{ $field_name }}"  wire:change="clearNominal({{$key}})" >
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    @endif

                </div>
                @if ($key != 0)
                <div class="px-1 pt-4">
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

            <div class="px-1 mb-3">
                <button class="btn text-white text-xl btn-info btn-sm" wire:click.prevent="add" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="add">Tambah <i class="bi bi-plus"></i></span>
                    <span wire:loading wire:target="add" class="text-center">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </span>
                </button>
            </div>

            <hr>

            {{-- <div class="flex grid grid-cols-4 gap-2 mt-2">
                <div class="form-group">
                    <?php
                    $field_name = 'penjualan_sales.tipe_pembayaran';
                    $field_lable = label_case('tipe_pembayaran');
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    $disabled = '';
                    ?>
                    <label class="text-gray-700 mb-0" for="{{ $field_name }}">Tipe Pembayaran <span class="text-danger">*</span></label>
                    <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" >
                        <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                        <option value="cicil">Cicil</option>
                        <option value="jatuh_tempo">Jatuh Tempo</option>
                        <option value="lunas">Lunas</option>
                    </select>
                    @if ($errors->has($field_name))
                    <span class="invalid feedback" role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                    </span>
                    @endif
                </div>
                @if ($this->penjualan_sales['tipe_pembayaran'] == 'cicil')
                <div id="cicilan" class="form-group">
                    <?php
                    $field_name = 'penjualan_sales.cicil';
                    $field_lable = __('cicil');
                    $field_placeholder = Label_case($field_lable);
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = '';
                    ?>
                    <label class="text-gray-700 mb-0" for="{{ $field_name }}"> {{ $field_placeholder }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                        <option value="" selected disabled>Jumlah {{ $field_lable }}an</option>
                        <option value="1">1 kali</option>
                        <option value="2">2 kali </option>
                    </select>
                    @if ($errors->has($field_name))
                    <span class="invalid feedback" role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                    </span>
                    @endif
                </div>
                @elseif ($this->penjualan_sales['tipe_pembayaran'] == 'jatuh_tempo')
                <div id="jatuh_tempo" class="form-group">
                    <?php
                    $field_name = 'penjualan_sales.tgl_jatuh_tempo';
                    $field_lable = __('Tanggal');
                    $field_placeholder = Label_case($field_lable);
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    ?>
                    <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                    <input type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{$field_name}}_input" wire:model="{{ $field_name }}" min="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}">
                    @if ($errors->has($field_name))
                    <span class="invalid feedback" role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                    </span>
                    @endif
                </div>
                @endif
            </div> --}}

            @if ($this->penjualan_sales['tipe_pembayaran'] == 'cicil' && $this->penjualan_sales['cicil'] != '')
            <div class="card p-6 bg-gray-100 rounded-lg shadow-md">
                <div class="text-md font-bold mb-4 text-dark">Input Tanggal Cicilan</div>

                @for ($i = 1; $i <= $this->penjualan_sales['cicil']; $i++)
                    <div class="mb-4">
                        <label for="cicilan{{ $i }}" class="text-gray-600 text-sm mb-2 block">Cicilan Ke {{ $i }}</label>
                        <div class="relative rounded-lg">
                            <?php
                            $field_name = 'detail_cicilan.'.$i;
                            $field_lable = __('Tanggal Jatuh Tempo');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            ?>
                            <input
                                type="date"
                                id="{{ $field_name }}"
                                name="{{ $field_name }}"
                                wire:model="{{ $field_name }}"
                                wire:change="resetDetailCicilanAfterwards({{$i}})"
                                min="{{ $this->getMinCicilDate($i)}}"
                                class="block w-full py-2 px-3 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            />

                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>

            @endif

            <div class="flex flex-col items-end mb-8 mt-3">
                @if($isPersen)
                <div class="mb-2 md:mb-1 flex items-center">
                    <label class="w-30 text-gray-700 block text-sm tracking-wide">Total Berat</label>
                    <span class="mr-4 md:block">:</span>
                    <div class="flex-1">
                        <input class="form-control form-control-sm" wire:model.debounce.1s="penjualan_sales.total_jumlah" type="text" placeholder="0" readonly>
                    </div>
                </div>
                @else
                <div class="mb-2 md:mb-1 flex items-center">
                    <label class="w-30 text-gray-700 block text-sm tracking-wide">Total Nominal Rp. </label>
                    <span class="mr-4 md:block">:</span>
                    <div class="flex-1">
                        <input class="form-control form-control-sm" type-currency="IDR" wire:model.debounce.1s="penjualan_sales.total_nominal" type="text" placeholder="0" readonly>
                    </div>
                </div>
                @endif
            </div>






</div>




<div class="pt-2 border-t flex justify-between">
    <div></div>
    <div class="form-group">
        <a class="px-5 btn btn-outline-danger" href="{{ route("penjualansale.index") }}">
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