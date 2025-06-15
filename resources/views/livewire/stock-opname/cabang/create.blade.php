<div class="row mt-0 p-3">


    <div class="col-md-5 bg-white">

        @if(!auth()->user()->isUserCabang())
        <div class="form-group mt-3">
            <?php
                $field_name = 'cabang_id';
                $field_lable = __('Pilih Canag');
                $field_placeholder = Label_case($field_lable);
                $required = '';
            ?>
            <select id="{{ $field_name }}" class="form-control"  name="{{ $field_name }}" wire:model = "{{ $field_name }}">
                <option value="">Pilih </option>
                @foreach(\Modules\Cabang\Models\Cabang::all() as $item)
                    <option data-val="{{ $item->id }}" value="{{ $item->id }}" > {{ $item->name }} </option>
                @endforeach
            </select>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>
        @endif
        <div class="pt-3">
            {{-- <livewire:distribusi-toko.berlian.table /> --}}
            <div>

                <p class="uppercase text-lg text-gray-600 font-semibold">Input Barcode</p>
                <hr style="
                    height: 1px;
                    border: none;
                    color: #333;
                    background-color: #333;">

         
  <div class="px-2 ">
                       <div class="form-group">
                                <input id = "barcodeForm" type="text" class="form-control rounded rounded-lg sortir text-center" placeholder="Kode Produk" style="width: 100%;" wire:model='kode_produk' wire:keydown.enter="submitBarcode()" autofocus>
                            </div>
                    </div>
                
<div class="px-2 justify-between flex py-1">
<div class="uppercase text-md mt-1 text-gray-600 font-semibold">Input Manual</div>

<div class="form-group">
<input type="text" class="form-control form-control-sm" placeholder="Cari Produk" style="width: 100%;" >
</div>

</div>
              
                <div class="col-md-12 mt-2">
                    <!-- Search box -->
                   
                    <!-- Paginated records -->
                    <div class="table-responsive">
                        <table id="produksisTable" class="table table-sm table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="no-sort text-center">@lang('No')</th>
                                    <th class="no-sort">@lang('Image')</th>
                                    <th class="leading-4 no-sort">@lang('Kode Produk')</th>
                                    <th class="leading-4 no-sort">@lang('Produk Informasi')</th>
                                    <th class="align-middle">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->count())
                                @foreach ($products as $key => $value)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td> <a href="/{{ imageUrl() .'produksi/' . @$value->images }}" data-lightbox="{{ $value->images }} " b class="single_image">
                                            <img src="/{{ imageUrl() .'produksi/' . @$value->images }}" order="0" width="80" class="img-thumbnail" align="center"/>
                                        </a>
                                    </td>
                                    <td> {{ $value->product_code }} </td>
                                    <td> {{ $value->group?->name }} {{ $value->karat?->name  }} | {{ $value->berat_emas }} gr </td>
                                    <td>
                                        <button wire:click="selectProduct('{{ $value }}')"
                                        class="w-100 btn btn-sm btn-outline-success "
                                        style="cursor: pointer;"> Tambah
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" align="center">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <!-- Pagination navigation links -->
                        {{ $products->links() }}

                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="col-md-7">
        <div class="card">

            <div class="card-body">
                @include('utils.alerts')
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="reference">Reference <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="reference" wire:model="reference" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="from-group">
                                <div class="form-group">
                                    <label for="date">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm" name="date" wire:model="date" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="tablelist">
                            <thead>
                                <tr class="align-middle">

                                    <th class="no-sort text-center">@lang('No')</th>
                                    <th class="no-sort">@lang('Image')</th>
                                    <th class="no-sort">@lang('Kode Produk')</th>
                                    <th class="no-sort">@lang('Produk Informasi')</th>
                                    <th class="align-middle">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($so_details as $index => $val )
                                @php
                                    $image = !empty($val['images']) ? $val['images'] : '';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td> <a href="/{{ imageUrl() .'produksi/' . @$image }}" data-lightbox="{{ $image }} " b class="single_image">
                                            <img src="/{{ imageUrl() .'produksi/' . @$image }}" order="0" width="100" class="img-thumbnail" align="center"/>
                                        </a>
                                    </td>
                                    <td> {{ !empty($val['product_code']) ? $val['product_code'] : ''  }} </td>
                                    <td> {{ @$val['group']['name'] }} {{ @$val['karat']['name']  }} | {{ @$val['berat_emas'] }} gr </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" wire:click="remove({{ $index }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    <div class="form-group">
                        <label for="notes">Note <span class="small text-danger">( @lang('If Needed'))</span></label>
                        <textarea wire:model="note" name="notes" id="notes" rows="3" class="form-control"> </textarea>
                    </div>




                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            @lang('Create Adjustment') <i class="bi bi-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <div class="col-md-7">
        <div class="card">

            <div class="card-body">
                @include('utils.alerts')
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                    <?php
                                        $field_name = 'distribusi_toko.no_distribusi_toko';
                                        $field_lable = label_case('No Surat Jalan');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <input type="text" class="form-control form-control-sm" name="{{ $field_name }}" wire:model="{{ $field_name }}" required readonly>
                                    @if ($errors->has($field_name))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                    <?php
                                        $field_name = 'distribusi_toko.date';
                                        $field_lable = label_case('Date');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">Date</label>
                                    <input type="date" class="form-control form-control-sm" name="{{ $field_name }}" wire:model="{{ $field_name }}" required>
                                    @if ($errors->has($field_name))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                    <?php
                                        $field_name = 'distribusi_toko.cabang_id';
                                        $field_lable = label_case('cabang');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">Cabang</label>
                                    <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" >
                                        <option value="" selected>Pilih Cabang</option>
                                        @foreach($cabang as $sup)
                                        <option value="{{$sup->id}}">
                                            {{$sup->name}}
                                        </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has($field_name))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="tablelist">
                            <thead>
                                <tr class="align-middle">
                                    <th class="align-middle">@lang('No')</th>
                                    <th class="align-middle">@lang('Image')</th>
                                    <th class="align-middle">@lang('Kode Produk')</th>
                                    <th class="align-middle">@lang('Produk Informasi')</th>
                                    <th class="align-middle">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distribusi_toko_details as $index => $val )
                                @php
                                    $image = !empty($val['images']) ? $val['images'] : '';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td> <a href="/{{ imageUrl() .'produksi/' . @$image }}" data-lightbox="{{ $image }} " b class="single_image">
                                            <img src="/{{ imageUrl() .'produksi/' . @$image }}" order="0" width="100" class="img-thumbnail" align="center"/>
                                        </a>
                                    </td>
                                    <td> {{ !empty($val['product_code']) ? $val['product_code'] : ''  }} </td>
                                    <td> {{ $val['group']['name'] }} {{ $val['karat']['name']  }} | {{ $val['berat_emas'] }} gr </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" wire:click="remove({{ $index }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            @lang('Create Distribution') <i class="bi bi-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
</div>

@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('alreadySelected', function () {
            toastr.error('Item sudah dipilih!');
        });


        $("#cabang_id").on('change', function(){
            if($("#cabang_id").val()) {
                if(confirm('Jika cabang dirubah, maka semua perubahan akan direset!')) {
                    // Livewire.emit('resetAll'); // Belum
                }
            }

        })
    });
</script>

@endpush