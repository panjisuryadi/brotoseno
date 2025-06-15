<div class="row mt-0 p-3">


    <div class="col-md-5 bg-white">
        <div class="pt-3">
            {{-- <livewire:distribusi-toko.berlian.table /> --}}
            <div>

 <div class="flex justify-between px-2 border-bottom">
     <h2 class="text-base text-gray-400 font-semibold">Input Barcode</h2>

 </div>

                
              

                <div class="col-md-12 mt-2">
                    <!-- Search box -->
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                                <input id = "barcodeForm" type="text" class="form-control rounded rounded-lg sortir text-center" placeholder="Kode Produk" style="width: 100%;" wire:model='kode_produk' wire:keydown.enter="submitBarcode()" autofocus>
                            </div>
                        </div>
                    </div>
                </div>

                
               
                <div class="col-md-12 mt-2">

                    <div class="flex justify-between px-2 border-top pt-2">
                        
                    <div class="mt-2">
                        <p class="text-sm text-gray-400 font-semibold">Input Manual</p>
                    </div>

                    <div>
                        
                             <div class="form-group">
                                <input type="text" class="form-control" placeholder="Cari Produk" style="width: 100%;" >
                            </div>

                    </div>

                    </div>
                    <!-- Search box -->
         
                    <!-- Paginated records -->
                    <div class="table-responsive">
                        <table id="produksisTable" class="table table-sm table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="no-sort text-center">No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Kode Produk</th>
                                    <th class="no-sort">Produk Info</th>
                                    <th class="no-sort text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($products->count())
                                @foreach ($products as $key => $value)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td> <a href="/{{ imageUrl(). @$value->images }}" data-lightbox="{{ $value->images }} " b class="single_image">
                                            <img src="/{{ imageUrl(). @$value->images }}" order="0" width="100" class="img-thumbnail" align="center"/>
                                        </a>
                                    </td>
                                    <td> {{ $value->product_code }} </td>
                                    <td class="text-center"> 
                                        <span class="btn btn-sm btn-warning text-dark font-bold">
                                             {{ @$value->group?->name }} {{ @$value->karat?->name  }} | {{ $value->berat }} gr 
                                        </span>
                                    
                                    </td>
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

<div class="grid gap-2 space-x-1 lg:grid-cols-3 mb-4">
    <div>
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
    <div>

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
    <div>

<div class="form-group">
    <?php
    $field_name = 'distribusi_toko.cabang_id';
    $field_lable = label_case('cabang');
    $field_placeholder = $field_lable;
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = "required";
    ?>
    <label for="{{ $field_name }}">Cabang</label>
    <select class="form-control form-control-sm @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" >
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
                                    <th class="align-middle">@lang('Produk Info')</th>
                                    <th class="align-middle text-center">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distribusi_toko_details as $index => $val )
                                @php
                                    $image = !empty($val['images']) ? $val['images'] : '';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td> <a href="/{{ imageUrl(). @$image }}" data-lightbox="{{ $image }} " b class="single_image">
                                            <img src="/{{ imageUrl(). @$image }}" order="0" width="100" class="img-thumbnail" align="center"/>
                                        </a>
                                    </td>
                                    <td> {{ !empty($val['product_code']) ? $val['product_code'] : ''  }} </td>
                           
                                     <td class="text-center"> 
                                        <span class="btn btn-sm btn-warning text-dark font-bold">
                                            {{ @$val['group']['name'] }} {{ @$val['karat']['name']  }} | {{ $val['berat_emas'] }} gr 
                                        </span>
                                    
                                    </td>
                                    <td class="text-center">

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
    </div>
</div>

@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('alreadySelected', function () {
            toastr.error('Item sudah dipilih!');
        });
    });
</script>

@endpush