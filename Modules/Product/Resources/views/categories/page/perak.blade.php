              <div class="grid grid-cols-3 gap-3">
                            <div class="border-right pr-3">
                                <div class="form-group">
                                    <label for="image">Product Images <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Max Files: 3, Max File Size: 1MB, Image Size: 400x400"></i></label>
                                    <div class="py-2">
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
                                    <div id="upload1" style="display: block !important;" class="align-items-center justify-content-center">
                                        <div  class="h-320 dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                            <div class="dz-message" data-dz-message>
                                                <i class="text-red-800 bi bi-cloud-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 bg-transparent">


                                <div class="flex-wrap">
                                     <div class="form-group">
                                            <label for="product_name">@lang('Product Name') <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="product_name" required value="{{ old('product_name') }}">
                                        </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label for="product_note">Supplier</label>
                                            <select class="form-control select2" name="supplier_id" id="supplier_id" required>
                                                <option value="" selected disabled>Select Supplier</option>
                                                @foreach(\Modules\People\Entities\Supplier::all() as $sup)
                                                <option value="{{$sup->id}}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                                {{$sup->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_code">Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="product_code" readonly value="{{ $code }}">
                                        </div>


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
                                <div class="flex row px-3 py-0">
                                    {{-- =================================================================================== --}}
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_emas">@lang('Berat') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_emas" type="number" class="form-control" name="berat_emas" required value="{{ old('berat_emas') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_accessories">@lang('Berat Accessories') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_accessories" type="number" class="form-control" name="berat_accessories" required value="{{ old('berat_accessories') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_label">@lang('Berat Label') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_label" type="number" class="form-control" name="berat_label" required value="{{ old('berat_label') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="berat_total">@lang('Berat Total') <span class="text-danger">*</span></label>
                                                <input min="0" step="0.01" id="berat_total" type="number" class="form-control" name="berat_total" required value="{{ old('berat_total') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- =================================================================================== --}}
                                </div>
                                <div class="flex relative py-1">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Harga</span>
                                    </div>
                                </div>
                                <div class="flex row px-3 py-0">
                                    {{-- harga =================================================================================== --}}
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="product_price">@lang('Price') <span class="text-danger">*</span></label>
                                                <input id="product_price" type="text" class="form-control" name="product_price" required value="{{ old('product_price') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="product_cost">@lang('Cost') <span class="text-danger">*</span></label>
                                                <input id="product_cost" type="text" class="form-control" name="product_cost" required value="{{ old('product_cost') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="product_sale">@lang('Jual') <span class="text-danger">*</span></label>
                                                <input id="product_sale" type="text" class="form-control" name="product_sale" required value="{{ old('product_sale') }}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- =================================================================================== --}}
                                </div>
                                <div class="flex relative py-0">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Lokasi <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Lokasi Penyimpanan (Gudang /Rak etc."></i></span>
                                    </div>
                                </div>
                                {{-- =================================================================================== --}}
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gudang_id">@lang('Gudang') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="gudang_id" id="gudang_id" required>
                                                <option value="" selected disabled>Select Gudang</option>
                                                @foreach(\Modules\Gudang\Models\Gudang::all() as $gudang)
                                                 <option value="{{$gudang->id}}" {{ old('gudang_id') == $gudang->id ? 'selected' : '' }}>
                                                    {{$gudang->code}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                     <div class="form-group">
                                            <label for="etalase_id">@lang('Etalase') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="etalase_id" id="etalase_id" required>
                                                <option value="" selected disabled>Select Etalase</option>
                                                @foreach(\Modules\DataEtalase\Models\DataEtalase::all() as $et)
                                                 <option value="{{$et->id}}" {{ old('etalase_id') == $et->id ? 'selected' : '' }}>
                                                    {{$et->code}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                       <div class="form-group">
                                            <label for="baki_id">@lang('Baki') <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="baki_id" id="baki_id" required>
                                                <option value="" selected disabled>Kode Baki</option>
                                                @foreach(\Modules\Baki\Models\Baki::all() as $bk)
                                                 <option value="{{$bk->id}}" {{ old('baki_id') == $bk->id ? 'selected' : '' }}>
                                                    {{$bk->code}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- =================================================================================== --}}
                                <div class="flex row px-3 py-0">
                                    <div class="p-0 col-lg-12">
                                        <div class="form-group">
                                            <label for="product_note">Note</label>
                                            <textarea name="product_note" id="product_note" rows="4 " class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
