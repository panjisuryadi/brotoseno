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

    <!-- HERE -->
    <!-- <form wire:submit.prevent="submit" enctype="multipart/form-data"> -->
    <form method="POST" action="/penerimaan-barangs/product" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="flex relative py-3">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-gray-300"></div>
                            </div>
                            @if (!empty($errors->messages))
                                @dd($errors)
                            @endif

                            <div class="relative flex justify-left">
                                <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{ $nama }} | Berat kotor = {{ $products[0]->berat_kotor }} | Berat Real = {{ $products[0]->berat_real }} <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{ $nama }} | Berat kotor = {{ $products[0]->berat_kotor }} | Berat Real = {{ $products[0]->berat_real }}"></i>
                                </span>


                            </div>


                            <a class="flex" href="{{ route('goodsreceipt.index') }}">
                                <div class="absolute bottom-7 right-0 flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
                                    <i class="bi bi-house text-gray-600"></i>
                                </div>
                            </a>

                        </div>
                        @php
                            $number = 0; // Declare and initialize the variable
                        @endphp

                        @foreach($products as $pro)
                            @php
                                $id_karat = $pro->karat_id;  
                            @endphp
                            @for($x = 0; $x < $pro->qty; $x++)
                            <div class="flex flex-row grid grid-cols-3 gap-2 mt-2">

                                <div class="px-0 py-2">
                                    <div class="form-group">
                                        <div class="py-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                                                <label class="form-check-label" for="up2">Upload</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="upload" id="up1">
                                                <label class="form-check-label" for="up1">Webcam</label>
                                            </div>
                                        </div>
                                        <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center" wire:ignore>
                                        @livewire('webcam', ['key' => 0], key('cam-'. 0))
                                        </div>
                                        <div id="upload1" wire:ignore>
                                            <div class="form-group">

                                                <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                                    <div class="dz-message" data-dz-message>
                                                        <i class="bi bi-cloud-arrow-up"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first('image') }}</small class="text-danger">
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-span-2 px-2">
                                    <div class="flex flex-row grid grid-cols-2 gap-1">
                                        <div class="form-group">
                                            <?php
                                            $field_name = 'category[]';
                                            $field_lable = label_case('category');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="product_category">Product Category</label>
                                            <select id="product_category" class="form-control @error('new_product.product_category_id') is-invalid @enderror" name="{{ $field_name }}">
                                            <option value="">Semua Produk</option>

                                                @foreach($product_categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'model[]';
                                            $field_lable = label_case('model');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                            <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                <option value="" selected disabled>Pilih Model</option>
                                                @foreach($models as $model)
                                                <option value="{{$model->id}}">
                                                    {{$model->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'karat[]';
                                            $field_id   = 'karat_'.$number;
                                            $field_lable = label_case('karat');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">@lang('Karat') <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}" readonly>
                                                @foreach($dataKarat as $karat)
                                                    @if ($id_karat == $karat->id)
                                                        <option value="{{ $karat->id }}" selected>{{ $karat->label }}</option>
                                                    @else
                                                        <!-- <option value="{{ $karat->id }}" >{{ $karat->label }}</option> -->
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'group[]';
                                            $field_id   = 'group_'.$number;
                                            $field_lable = label_case('group');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">@lang($field_lable)
                                                <span class="text-danger">*</span>
                                                <span class="small">Jenis Perhiasan</span>
                                            </label>
                                            <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}">
                                                <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                                @foreach($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div> 

                                        <div class="form-group">
                                            <?php
                                            $field_name = 'code[]';
                                            $field_id   = 'code_'.$number;
                                            $field_lable = label_case('code');
                                            $field_placeholder = $field_lable;
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = "required";
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="{{ $field_id }}" name="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" readonly>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info relative rounded-l-none" onclick="gencode({{ $number }});" type="button">Check</button>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- ///batas --}}
                                    <div class="flex flex-row grid grid-cols-4 gap-2">
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'acc[]';
                                        $field_id   = 'acc_'.$number;
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
                                        id="{{ $field_id }}"
                                        onkeyup="getotal({{ $number }});"
                                        id="{{ $field_name }}"
                                        placeholder="{{ $field_placeholder }}"
                                        min="0"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'tag[]';
                                        $field_id   = 'tag_'.$number;
                                        $field_lable = label_case('tag');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                        <input class="form-control @error($field_name) is-invalid @enderror"
                                        type="number"
                                        name="{{ $field_name }}"
                                        onkeyup="getotal( {{ $number }} );"
                                        min="0" step="0.001"
                                        id="{{ $field_id }}"
                                        placeholder="{{ $field_placeholder }}">
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'emas[]';
                                        $field_id   = 'emas_'.$number;
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
                                        id="{{ $field_id }}"
                                        onkeyup="getotal( {{ $number}} );"
                                        placeholder="{{ $field_placeholder }}">
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_name = 'total[]';
                                        $field_id   = 'total_'.$number;
                                        $field_lable = label_case('Total');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                        ?>
                                        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                        <input class="form-control"
                                        type="number"
                                        name="{{ $field_name }}"
                                        id="{{ $field_id }}"
                                        onkeyup="getotal({{ $number }});"
                                        placeholder="{{ $field_placeholder }}"
                                        readonly>
                                    </div>
                                </div>
                                </div>

                                {{-- batas --}}
                                </div>

                                <hr>

                                @php
                                    $number++;
                                @endphp
                            @endfor
                        @endforeach


                        <div class="mt-4 flex justify-between">
                            <div></div>
                            <div class="form-group">
                                <a class="px-5 btn btn-danger" href="{{ route("goodsreceipt.index") }}">
                                    @lang('Cancel')</a>
                                <button type="submit" class="px-5 btn btn-success">@lang('Save') <i class="bi bi-check"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

<!-- MODAL -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Tambah Produk</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="flex flex-row grid grid-cols-3 gap-2 mt-2">
                    <div class="px-0 py-2">
                        <div class="form-group">
                            <div class="py-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                                    <label class="form-check-label" for="up2">Upload</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="upload" id="up1">
                                    <label class="form-check-label" for="up1">Webcam</label>
                                </div>
                            </div>
                            <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center" wire:ignore>
                            @livewire('webcam', ['key' => 0], key('cam-'. 0))
                            </div>
                            <div id="upload1" wire:ignore>
                                <div class="form-group">

                                    <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                        <div class="dz-message" data-dz-message>
                                            <i class="bi bi-cloud-arrow-up"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($errors->has('image'))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first('image') }}</small class="text-danger">
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-span-2 px-2">
                        <div class="flex flex-row grid grid-cols-2 gap-1">
                            <div class="form-group">
                                <label for="product_category">Product Category</label>
                                <select id="product_category" class="form-control @error('new_product.product_category_id') is-invalid @enderror">
                                <option value="">Semua Produk</option>

                                    @foreach($product_categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <?php
                                $field_name = 'new_product.model_id';
                                $field_lable = label_case('model');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                    <option value="" selected disabled>Pilih Model</option>
                                    @foreach($models as $model)
                                    <option value="{{$model->id}}">
                                        {{$model->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <?php
                                $field_name = 'new_product.karat_id';
                                $field_id   = 'karat_'.$number;
                                $field_lable = label_case('karat');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">@lang('Karat') <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}" readonly>
                                    @foreach($dataKarat as $karat)
                                        @if ($id_karat == $karat->id)
                                            <option value="{{ $karat->id }}" selected>{{ $karat->label }}</option>
                                        @else
                                            <!-- <option value="{{ $karat->id }}" >{{ $karat->label }}</option> -->
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <?php
                                $field_name = 'new_product.group_id';
                                $field_id   = 'group_'.$number;
                                $field_lable = label_case('group');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">@lang($field_lable)
                                    <span class="text-danger">*</span>
                                    <span class="small">Jenis Perhiasan</span>
                                </label>
                                <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_id }}">
                                    <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                    @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div> 

                            <div class="form-group">
                                <?php
                                $field_name = 'new_product.code';
                                $field_id   = 'code_'.$number;
                                $field_lable = label_case('code');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="{{ $field_id }}" class="form-control @error($field_name) is-invalid @enderror" readonly>
                                    <span class="input-group-btn">
                                        <button class="btn btn-info relative rounded-l-none" onclick="gencode({{ $number }});" type="button">Check</button>
                                    </span>
                                </div>
                            </div>

                        </div>

                        {{-- ///batas --}}
                        <div class="flex flex-row grid grid-cols-4 gap-2">
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.accessories_weight';
                            $field_id   = 'acc_'.$number;
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
                            id="{{ $field_id }}"
                            onkeyup="getotal({{ $number }});"
                            id="{{ $field_name }}"
                            placeholder="{{ $field_placeholder }}"
                            min="0"
                            >
                        </div>
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.tag_weight';
                            $field_id   = 'tag_'.$number;
                            $field_lable = label_case('tag');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                            <input class="form-control @error($field_name) is-invalid @enderror"
                            type="number"
                            onkeyup="getotal( {{ $number }} );"
                            min="0" step="0.001"
                            id="{{ $field_id }}"
                            placeholder="{{ $field_placeholder }}">
                        </div>
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.gold_weight';
                            $field_id   = 'emas_'.$number;
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
                            id="{{ $field_id }}"
                            onkeyup="getotal( {{ $number}} );"
                            placeholder="{{ $field_placeholder }}">
                        </div>
                        <div class="form-group">
                            <?php
                            $field_name = 'new_product.total_weight';
                            $field_id   = 'total_'.$number;
                            $field_lable = label_case('Total');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                            <input class="form-control"
                            type="number"
                            name="{{ $field_name }}"
                            id="{{ $field_id }}"
                            onkeyup="getotal({{ $number }});"
                            placeholder="{{ $field_placeholder }}"
                            readonly>
                        </div>
                    </div>
                    </div>

                    {{-- batas --}}
                    </div>

                    <hr>

                    @php
                        $number++;
                    @endphp
            </div>
        </div>
    </div>
</div>

    <script>
        
    </script>
    @push('page_scripts')
    <script>
        function getotal(number){
            $('#total_' + number).val(0);
            let acc     = parseInt($('#acc_' + number).val());
            console.log(acc);
            let tag     = parseInt($('#tag_' + number).val());
            let emas    = parseInt($('#emas_' + number).val());
            let total   = acc + tag + emas;
            $('#total_' + number).val(total);
        }

        function gencode(number){
            $("#code_"+number).val('');
            let rand    = Math.floor(Math.random() * 1000);
            let group   = $('#group_' + number).find('option:selected').text();
            group       = group.substring(0, 1);
            let karat   = $('#karat_' + number).find('option:selected').text();
            karat       = karat.split('|')[0]?.trim();
            let date    = new Date();
            let formattedDate = ("0" + date.getDate()).slice(-2) + ("0" + (date.getMonth() + 1)).slice(-2) + date.getFullYear().toString().slice(-2);
            let code    = group+karat+formattedDate+rand;
            $("#code_"+number).val(code);
        }
    </script>
    @endpush


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
        url: "{{ route('dropzone.upload') }}",
        maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, .png',
        maxFiles: 1,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
            Livewire.emit('imageUploaded',response.name);
            console.log(response.name);
        },
        removedfile: function(file) {
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
            Livewire.emit('imageRemoved',name);
        },
        init: function() {
            @if(isset($product) && $product->getMedia('pembelian'))
            var files = {
                !!json_encode($product->getMedia('pembelian')) !!
            };
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

    window.addEventListener('webcam-image:remove', event => {
        $('#imageprev0').attr('src','');
    });
    window.addEventListener('uploaded-image:remove', event => {
        Dropzone.forElement("div#document-dropzone").removeAllFiles(true);
    });
</script>

@endpush

@push('page_scripts')

<script type="text/javascript">
    jQuery.noConflict();

    function show_tipe_pembayaran(){
        type    = this.val();
        muncul  = this.html();
        console.log(type);
        console.log(muncul);
    }

    
    
    (function($) {

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
                if (verified) {
                    e.preventDefault();
                }
            });
        });

    })(jQuery);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

@endpush

