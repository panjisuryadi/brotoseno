<form wire:submit.prevent="store" enctype="multipart/form-data">

        @csrf
      {{-- {{$mainkategori}} --}}
                      
                        <input type="hidden" name="product_barcode_symbology" value="QRCODE">
                        <input type="hidden" name="product_stock_alert" value="5">
                        <input type="hidden" name="product_quantity" value="1">
                        <input type="hidden" name="product_unit" value="Gram">
                        <div class="grid grid-cols-1 gap-3">
                            

                            <div class="col-span-2 bg-transparent">
                        
                                    <div class="flex flex-col grid grid-cols-3 gap-2">

                                    <!-- NO DISTRIBUSI TOKO -->
                                    <div class="form-group">
                                                <?php
                                                $field_name = 'distribusi_toko.no_distribusi_toko';
                                                $field_lable = label_case('no surat jalan');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                            <label for="{{ $field_name }}"> No Surat Jalan</label>
                                            <div class="flex-1">
                                                <input wire:model="{{ $field_name }}" type="text" id="{{ $field_name }}" placeholder="{{ $field_lable }}" class="form-control @error( $field_name) is-invalid @enderror" readonly>
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback"role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                        class="text-danger">
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                    <!-- DATE -->
                                        <div class="form-group">
                                            <?php
                                            $field_name = 'distribusi_toko.date';
                                            $field_lable = label_case('tanggal');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">Date</label>
                                            <div class="flex-1">
                                                <input wire:model="{{ $field_name }}" type="date" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror">
                                                @if ($errors->has($field_name))
                                                    <span class="invalid feedback"role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                        class="text-danger">
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                    <!-- CABANG -->
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


                                    @foreach($distribusi_toko_details as $key => $value)
                                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow my-4 relative">
                                        @if ($key > 0)
                                        <div class="absolute right-5 top-3 z-20">
                                            <button class="btn text-white btn-danger" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                                                <span wire:loading wire:target="remove({{$key}})" class="text-center">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                </span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="grid grid-cols-3 gap-5">
                                            <div class="col-span-2">

                                                <div class="grid grid-cols-2 gap-2">
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'distribusi_toko_details.' . $key . '.product_category';
                                                        $field_lable = label_case('kategori produk');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = "required";
                                                        ?>
                                                        <label for="{{ $field_name }}">Product Category</label>
                                                        <select id="{{ $field_name }}" wire:model="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" wire:change="changeProductCategory({{$key}})" onchange="setAdditionalAttribute({{$key}},'product_category_name', this);">
                                                        <option value="">All Products</option>
                                                            @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                                        $field_name = 'distribusi_toko_details.' . $key . '.group';
                                                        $field_lable = label_case('group');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = "required";
                                                        ?>
                                                        <label for="{{ $field_name }}">@lang($field_lable)
                                                            <span class="text-danger">*</span>
                                                            <span class="small">Jenis Perhiasan</span>
                                                        </label>
                                                        <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" onchange="setAdditionalAttribute({{$key}},'group_name', this);">
                                                            <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                                            @foreach(\Modules\Group\Models\Group::all() as $jp)
                                                            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
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
<div class="grid grid-cols-2 gap-2">
    

                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'distribusi_toko_details.' . $key . '.model';
                                                        $field_lable = label_case('model');
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = "required";
                                                        ?>
                                                        <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" onchange="setAdditionalAttribute({{$key}},'model_name', this);">
                                                            <option value="" selected disabled>Pilih Model</option>
                                                            @foreach(\Modules\ProdukModel\Models\ProdukModel::all() as $sup)
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
            
<div class="form-group">
    <?php
    $field_name = 'distribusi_toko_details.' . $key . '.code';
    $field_lable = label_case('code');
    $field_placeholder = $field_lable;
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = "required";
    ?>
    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="text" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" wire:model="{{ $field_name }}" readonly>
        <span class="input-group-btn">
            <button class="btn btn-info relative rounded-l-none" wire:click.prevent="generateCode({{$key}})">Chek</button>
        </span>
    </div>
    @if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>


</div>






                                               

                                        @if($distribusi_toko_details[$key]['product_category'] == $logam_mulia_id)
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="form-group">
                                                <?php
                                                $field_name = 'distribusi_toko_details.' . $key . '.certificate_id';
                                                $field_lable = label_case('certificate_id');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">@lang('Certificate') <span class="text-danger">*</span></label>
                                                <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                    <option value="" selected disabled>Pilih Certificate</option>
                                                    @foreach(\Modules\DiamondCertificate\Models\DiamondCertificate::all() as $certificate)
                                                    <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
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
                                                $field_name = 'distribusi_toko_details.' . $key . '.no_certificate';
                                                $field_lable = label_case('no_certificate');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">@lang('No .Certificate') <span class="text-danger">*</span></label>
                                                <input id="{{ $field_name }}" type="text" class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback"role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                    class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="flex relative py-1">
                                            <div class="absolute inset-0 flex items-center">
                                                <div class="w-full border-b border-gray-300"></div>
                                            </div>
                                            <div class="relative flex justify-left">
                                                <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="flex flex-row grid grid-cols-2 gap-2">
                                            
                                            <div class="form-group">
                                                <?php
                                                $field_name = 'distribusi_toko_details.' . $key . '.gold_weight';
                                                $field_lable = label_case('emas');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control @error($field_name) is-invalid @enderror"
                                                type="number"
                                                name="{{ $field_name }}"
                                                min="0" step="0.01"
                                                id="{{ $field_name }}"
                                                wire:model="{{ $field_name }}"
                                                wire:change="calculateTotalWeight({{$key}})"
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
                                                $field_name = 'distribusi_toko_details.' . $key . '.total_weight';
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
                                                wire:model="{{ $field_name }}"
                                                placeholder="{{ $field_placeholder }}"
                                                readonly>
                                            </div>
                                            
                                        </div>

                                        @else
                                        <div class="grid grid-cols-2 gap-2">
                                            <!-- <div class="form-group">
                                                <?php
                                                $field_name = 'distribusi_toko_details.' . $key . '.gold_category';
                                                $field_lable = label_case('kategori emas');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">Kategori Emas</label>
                                                <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                    <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                                    @foreach(\Modules\GoldCategory\Models\GoldCategory::all() as $sup)
                                                    <option value="{{$sup->id}}">
                                                    {{$sup->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has($field_name))
                                                <span class="invalid feedback"role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                    class="text-danger">
                                                </span>
                                                @endif

                                            </div> -->
                                            <div class="form-group">
                                                <?php
                                                $field_name = 'distribusi_toko_details.' . $key . '.karat';
                                                $field_lable = label_case('karat');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">@lang('Karat') <span class="text-danger">*</span></label>
                                                <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                    <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                                    @foreach($dataKarat as $jp)
                                                    <option value="{{ $jp->id }}">{{ $jp->label }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has($field_name))
                                                <span class="invalid feedback"role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                    class="text-danger">
                                                </span>
                                                @endif
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
                                                $field_name = 'distribusi_toko_details.' . $key . '.accessoris_weight';
                                                $field_lable = label_case('Accessories');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control @error($field_name) is-invalid @enderror"
                                                type="number"
                                                name="{{ $field_name }}"
                                                step="0.001"
                                                wire:model="{{ $field_name }}"
                                                wire:change="calculateTotalWeight({{$key}})"
                                                id="{{ $field_name }}"
                                                placeholder="{{ $field_placeholder }}"
                                                min="0"
                                                >
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback"role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                    class="text-danger">
                                                </span>
                                                @endif
                                            </div>

                                        <div class="form-group">
                                                <?php
                                                $field_name = 'distribusi_toko_details.' . $key . '.label_weight';
                                                $field_lable = label_case('tag');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <input class="form-control @error($field_name) is-invalid @enderror"
                                                type="number"
                                                wire:model="{{ $field_name }}"
                                                wire:change="calculateTotalWeight({{$key}})"
                                                min="0" step="0.001"
                                                id="{{ $field_name }}"
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
                                                $field_name = 'distribusi_toko_details.' . $key . '.gold_weight';
                                                $field_lable = label_case('emas');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control @error($field_name) is-invalid @enderror"
                                                type="number"
                                                name="{{ $field_name }}"
                                                min="0" step="0.001"
                                                id="{{ $field_name }}"
                                                wire:model="{{ $field_name }}"
                                                wire:change="calculateTotalWeight({{$key}})"
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
                                                $field_name = 'distribusi_toko_details.' . $key . '.total_weight';
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
                                                wire:model="{{ $field_name }}"
                                                placeholder="{{ $field_placeholder }}"
                                                readonly>
                                            </div>
                                            
                                        </div>
                                        {{-- END BERAT --}}
                                        @endif

                                            </div>



                                            <div class="form-group">
                                                <?php
                                                $field_name = 'distribusi_toko_details.' . $key . '.webcam_image';
                                                $field_lable = label_case('webcam upload');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                

                                                @livewire('webcam', ['key' => $key], key('cam-'.$key))
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback"role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                    class="text-danger">
                                                </span>
                                                @endif
                                                
                                            </div>

                                        </div>

                                        
                                        
                                        
                                        
                                        
                                    </div>
                                    @endforeach


                                            <!-- <div class="flex row px-3 py-0">
                                                <div class="p-0 col-lg-12">
                                                    <div class="form-group">
                                                        <label for="product_note">Note</label>
                                                        <textarea name="product_note" id="product_note" rows="4 " class="form-control"></textarea>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="form-group">
                                            <button class="btn text-white btn-info" wire:click.prevent="add" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i>Tambah Item</span>
                                                <span wire:loading wire:target="add" class="text-center">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="form-group">
                                        
                                        </div>
                                    </div>
                                    <div class="flex justify-between px-3 pb-2 border-bottom">
                                        <div class="form-group">
                                            
                                        </div>
                                        <div class="form-group">
                                        
                                            <a class="px-5 btn btn-danger"
                                                href="{{ route("goodsreceipt.index") }}">
                                            @lang('Cancel')</a>
                                            <button id="SimpanTambah" type="submit" class="px-4 btn btn-primary">@lang('Save')  <i class="bi bi-check"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </form>

@push('page_scripts')

<script type="text/javascript">

function setAdditionalAttribute(key,name,selectElement){
    let selectedText = selectElement.options[selectElement.selectedIndex].text;
    Livewire.emit('setAdditionalAttribute',key,name,selectedText);
}
    
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush