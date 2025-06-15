<div class="modal fade" id="create-barangluar-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title text-lg font-bold" id="addModalLabel">Penerimaan Barang Luar</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body p-4">
                <form>
                    <div class="grid grid-cols-3 gap-2 mb-3">
                            <div class="form-group">
                                <?php
                                $field_name = 'customer';
                                $field_lable = label_case('nama customer');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" wire:model.lazy="{{ $field_name }}">
                                </div>
                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <?php
                                $field_name = 'date';
                                $field_lable = label_case('tanggal');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <div class="flex-1">
                                    <input wire:model="{{ $field_name }}" type="date" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" max="{{ $today }}">
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                            </div>
                    </div>
                    <div class="grid grid-cols-4 gap-10">
                        <div class="col-span-2">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="form-group">
                                    <label for="product_category">Product Category</label>
                                    <select id="product_category" wire:model="data.additional_data.product_category.id" class="form-control @error('data.additional_data.product_category.id') is-invalid @enderror" wire:change="productCategoryChanged" onchange="setAdditionalAttribute('product_category', this);">
                                    <option value="">Semua Produk</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('data.additional_data.product_category.id'))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first('data.additional_data.product_category.id') }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                    $field_name = 'data.additional_data.group.id';
                                    $field_lable = label_case('group');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">@lang($field_lable)
                                        <span class="text-danger">*</span>
                                        <span class="small">Jenis Perhiasan</span>
                                    </label>
                                    <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" onchange="setAdditionalAttribute('group', this);">
                                        <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                        @foreach($groups as $jp)
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
                                <div class="form-group">
                                    <?php
                                    $field_name = 'data.additional_data.model.id';
                                    $field_lable = label_case('model');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" onchange="setAdditionalAttribute('model', this);">
                                        <option value="" selected disabled>Pilih Model</option>
                                        @foreach($models as $sup)
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
                                    $field_name = 'data.additional_data.code';
                                    $field_lable = label_case('code');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" wire:model="{{ $field_name }}" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info relative rounded-l-none" wire:click.prevent="generateCode">Check</button>
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
                            @if($isLogamMulia)

                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-group">
                            <?php
                            $field_name = 'data.additional_data.certificate_id';
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
                            $field_name = 'data.additional_data.no_certificate';
                            $field_lable = label_case('no_certificate');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label for="{{ $field_name }}">@lang('No .Certificate') <span class="text-danger">*</span></label>
                            <input id="{{ $field_name }}" type="text" class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" wire:model.lazy="{{ $field_name }}">
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


                    <div class="grid grid-cols-2 gap-2">

                        <div class="form-group">
                            <?php
                            $field_name = 'data.gold_weight';
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
                            wire:model.lazy="{{ $field_name }}"
                            wire:change="calculateTotalWeight"
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
                            $field_name = 'data.total_weight';
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
                            wire:model.lazy="{{ $field_name }}"
                            placeholder="{{ $field_placeholder }}"
                            readonly>
                        </div>

                    </div>

                    @else

                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-group">
                                <?php
                                $field_name = 'data.karat_id';
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
                                $field_name = 'data.additional_data.accessories_weight';
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
                                wire:model.lazy="{{ $field_name }}"
                                wire:change="calculateTotalWeight()"
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
                                $field_name = 'data.additional_data.tag_weight';
                                $field_lable = label_case('tag');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}</label>
                                <input class="form-control @error($field_name) is-invalid @enderror"
                                type="number"
                                wire:model.lazy="{{ $field_name }}"
                                wire:change="calculateTotalWeight()"
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
                                $field_name = 'data.gold_weight';
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
                                wire:model.lazy="{{ $field_name }}"
                                wire:change="calculateTotalWeight()"
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
                                $field_name = 'data.total_weight';
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
                                wire:model.lazy="{{ $field_name }}"
                                placeholder="{{ $field_placeholder }}"
                                readonly>
                            </div>

                        </div>
                        @endif
                        </div>
                        <div class="col-span-2">
                            <div class="form-group">
                                <div class="py-2">
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
                                    <x-library.goodsreceipt-toko.barangluar.webcam />
                                </div>
                                <div id="upload1" style="display: block !important;" class="align-items-center justify-content-center" wire:ignore>
                                    <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                        <div class="dz-message" data-dz-message>
                                            <i class="text-red-800 bi bi-cloud-arrow-up"></i>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('data.additional_data.image'))
                                <span class="invalid feedback"role="alert">
                                    <small class="text-danger">{{ $errors->first('data.additional_data.image') }}.</small
                                    class="text-danger">
                                </span>
                                @endif
                            </div>
                        </div>



                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="form-group">
                            <?php
                            $field_name = 'grand_total';
                            $field_lable = label_case('nominal');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                            <div class="flex-1">
                                <input wire:model.1s="{{ $field_name }}" type="number" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror">
                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-center items-center">
                            <span class="text-2xl font-extrabold">{{ $this->grand_total_text }}</span>
                        </div>
                    </div>

                    <div class="card shadow-md">
                                <div class="card-header">
                                    <h3 class="font-bold text-medium">
                                        Metode Pembayaran
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input wire:model="multiple_payment_method" value="false" type="radio" id="customRadioInline1" name="customRadioInline" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline1">Single</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input wire:model="multiple_payment_method" value="true" type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline2">Multiple</label>
                                        </div>
                                    </div>
                                    @if ($multiple_payment_method == 'false')
                                    <div>
                                        <div class="px-1 grid grid-cols-3">
                                            <div class="form-group py-2">
                                                <select class="form-control" name="payment_method" id="payment_method" wire:model="payment_method">
                                                    <option value="" selected>Pilih Metode Pembayaran</option>
                                                    <option value="tunai">Tunai</option>
                                                    <option value="transfer">Transfer</option>
                                                    <option value="qr">QR</option>
                                                    <option value="edc">EDC</option>
                                                </select>
                                                @if ($errors->has('payment_method'))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first('payment_method') }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                            @if ($payment_method == 'transfer')
                                            <div class="form-group p-2">
                                                <select class="form-control @error('bank_id') is-invalid @enderror" name="bank_id" id="bank_id" wire:model="bank_id">
                                                    <option value="" selected>Pilih Bank</option>
                                                    @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}">
                                                        {{ $bank->nama_bank }} | {{ $bank->nama_pemilik }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('bank_id'))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first('bank_id') }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                            @endif

                                            @if ($payment_method == 'edc')
                                            <div class="form-group p-2">
                                                <select class="form-control @error('edc_id') is-invalid @enderror" name="edc_id" id="edc_id" wire:model="edc_id">
                                                    <option value="" selected>Pilih EDC</option>
                                                    @foreach($edcs as $edc)
                                                    <option value="{{ $edc->id }}">
                                                        {{ $edc->nama_rekening }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('edc_id'))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first('edc_id') }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @if ($payment_method == 'tunai')
                                        <div class="p-2 grid grid-cols-1 gap-4 my-2 mt-0">
                                            <div class="px-1">
                                                <div class="form-group">
                                                    <?php
                                                    $field_name = 'paid_amount';
                                                    ?>
                                                    <label for="{{$field_name}}">Jumlah yang dibayar</label>
                                                    <input id="{{$field_name}}" type="number" class="form-control text-xl @error($field_name) is-invalid @enderror" name="{{$field_name}}" wire:model.debounce.1s="{{$field_name}}" min="0">
                                                    @if ($errors->has($field_name))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="return_amount_text">Kembalian</label> <span class="text-danger small" id="message"></span>
                                                    <input id="return_amount_text" type="text" class="form-control text-black text-xl" name="return_amount_text" value="{{ $this->return_amount_text}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif ($payment_method == 'transfer' && !empty($bank_id))
                                        <div class="p-2 grid grid-cols-2 gap-4 my-2 mt-0">
                                            @php
                                            $selected_bank = $this->banks->find($this->bank_id);
                                            @endphp
                                            <div class="px-1">
                                                <div class="mb-3">
                                                    <p class="text-medium">Kode / Nama Bank</p>
                                                    <p class="font-medium text-xl">{{ $selected_bank->kode_bank }} {{$selected_bank->nama_bank}}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <p class="text-medium">Nama Pemilik</p>
                                                    <p class="font-medium text-xl">{{ $selected_bank->nama_pemilik }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <p class="text-medium">No Rekening</p>
                                                    <p class="font-medium text-xl">{{ $selected_bank->no_akun }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif ($payment_method == 'edc' && !empty($edc_id))
                                        <div class="p-2 grid grid-cols-2 gap-4 my-2 mt-0">
                                            @php
                                            $selected_edc = $this->edcs->find($this->edc_id);
                                            @endphp
                                            <div class="px-1">
                                                <div class="mb-3">
                                                    <p class="text-medium">Nama Bank</p>
                                                    <p class="font-medium text-xl">{{$selected_edc->nama_rekening}}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <p class="text-medium">Kode EDC</p>
                                                    <p class="font-medium text-xl">{{ $selected_edc->kode_bank }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @elseif ($multiple_payment_method == 'true')
                                        <div class="mb-3 flex justify-start">
                                            <div>
                                                <p class="text-medium">Grand Total : <span class="font-bold">{{ $this->grand_total_text }}</span></p>
                                                <p class="text-medium">Jumlah yang dibayar : <span class="font-bold">{{ $this->total_payment_amount_text }}</span></p>
                                                <p class="text-medium">Sisa bayar : <span class="font-bold">{{ $this->remaining_payment_amount_text }}</span></p>
                                            </div>
                                        </div>
                                        @foreach ($payments as $index => $payment)
                                        <div class="card">
                                            <div class="card-header flex justify-between">
                                                <p>Metode Pembayaran ke - {{ $index + 1 }}</p>
                                                <div>
                                                    @if (count($payments) > 1)
                                                    <a wire:click="remove_payment_method({{$index}})" href="#" class="btn btn-sm btn-danger w-10"><i class="bi bi-trash"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="px-1 grid grid-cols-3">
                                                    <div class="form-group py-2">
                                                        <?php
                                                            $field_name = "payments.{$index}.method"
                                                        ?>
                                                        <select class="form-control" name="{{$field_name}}" id="{{$field_name}}" wire:model="{{$field_name}}">
                                                            <option value="" selected>Pilih Metode Pembayaran</option>
                                                            <option value="tunai">Tunai</option>
                                                            <option value="transfer">Transfer</option>
                                                            <option value="qr">QR</option>
                                                            <option value="edc">EDC</option>
                                                        </select>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    @if ($payments[$index]['method'] == 'transfer')
                                                    <div class="form-group p-2">
                                                        <?php
                                                            $field_name = "payments.{$index}.bank_id"
                                                        ?>
                                                        <select class="form-control @error($field_name) is-invalid @enderror" name="{{$field_name}}" id="{{$field_name}}" wire:model="{{$field_name}}">
                                                            <option value="" selected>Pilih Bank</option>
                                                            @foreach($banks as $bank)
                                                            <option value="{{ $bank->id }}">
                                                                {{ $bank->kode_bank }} | {{ $bank->nama_bank }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    @endif

                                                    @if ($payments[$index]['method'] == 'edc')
                                                    <div class="form-group p-2">
                                                        <?php
                                                            $field_name = "payments.{$index}.edc_id"
                                                        ?>
                                                        <select class="form-control @error($field_name) is-invalid @enderror" name="{{$field_name}}" id="{{$field_name}}" wire:model="{{$field_name}}">
                                                            <option value="" selected>Pilih EDC</option>
                                                            @foreach($edcs as $edc)
                                                            <option value="{{ $edc->id }}">
                                                                {{ $edc->nama_rekening }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    @endif
                                                </div>
                                                @if ($payments[$index]['method'] == 'tunai')
                                                <div class="p-2 grid grid-cols-1 gap-4 my-2 mt-0">
                                                    <div class="px-1">
                                                        <div class="grid grid-cols-2 gap-2">
                                                            <?php
                                                                $field_name = "payments.{$index}.amount";
                                                            ?>
                                                            <div class="col-span-2">
                                                                <label for="{{$field_name}}">Jumlah yang ingin dibayar</label> <span class="text-danger small" id="message"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <input id="{{$field_name}}" type="number" class="form-control text-black text-xl @error($field_name) is-invalid @enderror" wire:model.debounce.1s="{{$field_name}}" min="0" wire:change="amountUpdated({{$index}})">
                                                                @if ($errors->has($field_name))
                                                                <span class="invalid feedback" role="alert">
                                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                                </span>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <?php
                                                                    $field_name = "payments.{$index}.amount_text";
                                                                ?>
                                                                <input id="{{$field_name}}" type="text" class="form-control text-black text-xl" name="{{$field_name}}" value="{{ $this->getAmountText($index)}}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                            $field_name = "payments.{$index}.paid_amount";
                                                            ?>
                                                            <label for="{{$field_name}}">Jumlah yang dibayar</label>
                                                            <input id="{{$field_name}}" type="number" class="form-control text-xl @error($field_name) is-invalid @enderror" name="{{$field_name}}" wire:model.debounce.1s="{{$field_name}}" min="0" wire:change="paymentPaidAmountUpdated({{$index}})">
                                                            @if ($errors->has($field_name))
                                                            <span class="invalid feedback" role="alert">
                                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                                $field_name = "payments.{$index}.return_amount_text";
                                                            ?>
                                                            <label for="{{$field_name}}">Kembalian</label> <span class="text-danger small" id="message"></span>
                                                            <input id="{{$field_name}}" type="text" class="form-control text-black text-xl" name="{{$field_name}}" value="{{ $this->getReturnAmountText($index)}}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                @elseif ($payments[$index]['method'] == 'transfer' && !empty($payments[$index]['bank_id']))
                                                <div class="grid grid-cols-2 gap-2">
                                                    <?php
                                                        $field_name = "payments.{$index}.amount";
                                                    ?>
                                                    <div class="col-span-2">
                                                        <label for="{{$field_name}}">Jumlah yang ingin dibayar</label> <span class="text-danger small" id="message"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="{{$field_name}}" type="number" class="form-control text-black text-xl @error($field_name) is-invalid @enderror" wire:model.debounce.1s="{{$field_name}}" min="0" wire:change="amountUpdated({{$index}})">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            $field_name = "payments.{$index}.amount_text";
                                                        ?>
                                                        <input id="{{$field_name}}" type="text" class="form-control text-black text-xl" name="{{$field_name}}" value="{{ $this->getAmountText($index)}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="p-2 grid grid-cols-2 gap-4 my-2 mt-0">
                                                    @php
                                                    $selected_bank = $this->banks->find($payments[$index]['bank_id']);
                                                    @endphp
                                                    <div class="px-1">
                                                        <div class="mb-3">
                                                            <p class="text-medium">Kode / Nama Bank</p>
                                                            <p class="font-medium text-xl">{{ $selected_bank->kode_bank }} {{$selected_bank->nama_bank}}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p class="text-medium">Nama Pemilik</p>
                                                            <p class="font-medium text-xl">{{ $selected_bank->nama_pemilik }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p class="text-medium">No Rekening</p>
                                                            <p class="font-medium text-xl">{{ $selected_bank->no_akun }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @elseif ($payments[$index]['method'] == 'edc' && !empty($payments[$index]['edc_id']))
                                                <div class="grid grid-cols-2 gap-2">
                                                    <?php
                                                        $field_name = "payments.{$index}.amount";
                                                    ?>
                                                    <div class="col-span-2">
                                                        <label for="{{$field_name}}">Jumlah yang ingin dibayar</label> <span class="text-danger small" id="message"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="{{$field_name}}" type="number" class="form-control text-black text-xl @error($field_name) is-invalid @enderror" wire:model.debounce.1s="{{$field_name}}" min="0" wire:change="amountUpdated({{$index}})">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            $field_name = "payments.{$index}.amount_text";
                                                        ?>
                                                        <input id="{{$field_name}}" type="text" class="form-control text-black text-xl" name="{{$field_name}}" value="{{ $this->getAmountText($index)}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="p-2 grid grid-cols-2 gap-4 my-2 mt-0">
                                                    @php
                                                    $selected_edc = $this->edcs->find($payments[$index]['edc_id']);
                                                    @endphp
                                                    <div class="px-1">
                                                        <div class="mb-3">
                                                            <p class="text-medium">Nama Bank</p>
                                                            <p class="font-medium text-xl">{{$selected_edc->nama_rekening}}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p class="text-medium">Kode EDC</p>
                                                            <p class="font-medium text-xl">{{ $selected_edc->kode_bank }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @elseif ($payments[$index]['method'] == 'qr')
                                                <div class="grid grid-cols-2 gap-2">
                                                    <?php
                                                        $field_name = "payments.{$index}.amount";
                                                    ?>
                                                    <div class="col-span-2">
                                                        <label for="{{$field_name}}">Jumlah yang ingin dibayar</label> <span class="text-danger small" id="message"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="{{$field_name}}" type="number" class="form-control text-black text-xl @error($field_name) is-invalid @enderror" wire:model.debounce.1s="{{$field_name}}" min="0" wire:change="amountUpdated({{$index}})">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            $field_name = "payments.{$index}.amount_text";
                                                        ?>
                                                        <input id="{{$field_name}}" type="text" class="form-control text-black text-xl" name="{{$field_name}}" value="{{ $this->getAmountText($index)}}" disabled>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="flex justify-end">
                                            <a wire:click="add_payment_method" href="#" class="btn btn-sm btn-success w-10"><i class="bi bi-plus"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                </form>
        </div>
        <div class="modal-footer">
            <div class="float-right mt-5">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" wire:click.prevent="store">Tambah</button>
            </div>
        </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script src="{{ asset('js/dropzone.js') }}"></script>
<script type="text/javascript">
    $('#up1').change(function() {
        $('#upload2').toggle();
        $('#upload1').hide();
        });
    $('#up2').change(function() {
        $('#upload1').toggle();
        $('#upload2').hide();
    });
</script>
<script>
    var uploadedDocumentMap = {}
    Dropzone.options.documentDropzone = {
        url: '{{ route('dropzone.upload') }}',
        maxFilesize: 1,
        acceptedFiles: '.jpg, .jpeg, .png',
        maxFiles: 1,
        addRemoveLinks: true,
        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
            Livewire.emit('imageUploaded',response.name);
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
            Livewire.emit('imageRemoved',name);
        },
        init: function () {
            @if(isset($product) && $product->getMedia('images'))
                var files = {!! json_encode($product->getMedia('images')) !!};
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
<script>
    function setAdditionalAttribute(name,selectElement){
        let selectedText = selectElement.options[selectElement.selectedIndex].text;
        Livewire.emit('setAdditionalAttribute',name,selectedText);
    }

    document.addEventListener('livewire:load', function () {
        Livewire.on('reload-page-create', function () {
            window.location.reload();
            toastr.success('Item Berhasil di ditambahkan')
        });
    });

    window.addEventListener('webcam-image:remove', event => {
        $('#imageprev').attr('src','');
    });
    window.addEventListener('uploaded-image:remove', event => {
        Dropzone.forElement("div#document-dropzone").removeAllFiles(true);
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endpush
