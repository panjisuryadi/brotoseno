@extends('layouts.app')

@section('title', 'POS')

@section('third_party_stylesheets')
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">POS</li>
    </ol>
@endsection

@push('page_css')
<style type="text/css">
 
.c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 0.3rem;
}

/* This targets the visible Select2 box */
.select2-container {
    width: 350px !important;  /* or any size / 100% */
}


</style>
@endpush

<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

@section('content')
<div class="container-fluid">
<div class="card">
    <div class="card-body">
        <div class="row">

            <!-- Left Side: Product List -->
            <div class="col-md-7">
                <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th style="width: 5%!important;">No</th>
                            <th style="width: 15%!important;">{{ Label_case('image') }}</th>
                            <th style="width: 15%!important;">Code</th>
                            <th style="width: 20%!important;">{{ Label_case('product') }}</th>
                            <th style="width: 23%!important;" class="text-center">{{ Label_case('Karat | Berat') }}</th>
                            <th style="width: 17%!important;" class="text-center">{{ Label_case('Harga') }}</th>
                            <!-- <th style="width: 25%!important;" class="text-center">{{ Label_case('Date') }}</th> -->
                            <th style="width: 5%!important;" class="text-center">#</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Right Side: Selected Product + Actions -->
            <div class="col-md-5 d-flex flex-column justify-content-between border-start" style="min-height: 400px;">
                
                <!-- Placeholder for Selected Product (you'll use JS here) -->
                <!-- <div class="flex-grow-1 d-flex align-items-center justify-content-center"> -->
                <form action="./sale/insert" id="sale" method="post">
                    @csrf
                    <input type="hidden" name="customer" id="customer">
                    <input type="hidden" name="hidden_cash" id="hidden_cash">
                    <input type="hidden" name="hidden_edc" id="hidden_edc">
                    <input type="hidden" name="hidden_transfer" id="hidden_transfer">
                    <input type="hidden" name="hidden_qr" id="hidden_qr">
                    <input type="hidden" name="hidden_cc" id="hidden_cc">
                    <input type="hidden" name="hidden_muncul_cc" id="hidden_muncul_cc">
                    <input type="hidden" name="hidden_cicil" id="hidden_cicil">
                    <input type="hidden" name="hidden_bank" id="hidden_bank">
                    <input type="hidden" name="hidden_rekening" id="hidden_rekening">
                    <input type="hidden" name="persen_cc" id="persen_cc" value="{{$cc->value}}">
                    <div class="flex-grow-1 d-flex flex-column gap-2 overflow-auto" id="preview-area" style="max-height: 300px; /* or whatever fits your layout */overflow-y: auto;">
                        
                    <!-- <span class="text-muted">Selected product preview goes here</span> -->
                    </div>
                </form>

                <!-- Bottom Controls -->
                <div class="w-100">
                    <!-- Delete / Add Buttons -->
                    <!-- <div class="d-flex gap-2 mb-3"> -->
                    <div class="d-flex mb-3">
                        <!-- <button class="btn btn-outline-danger w-50" id="btn-delete-last">
                            <i class="hover:text-red-400 text-2xl text-gray-500 bi bi-trash"></i> Delete
                        </button> -->
                        <button class="btn btn-outline-primary w-100" id="btn-add-special" data-toggle="modal" data-target="#customProductModal">
                            <i class="hover:text-blue-400 text-2xl text-gray-500 bi bi-file-plus"></i> Custom
                        </button>
                        <button class="btn btn-outline-warning w-100" id="btn-add-special" data-toggle="modal" data-target="#tukar">
                            <i class="hover:text-blue-400 text-2xl text-gray-500 bi bi-file-plus"></i> Tukar Tambah
                        </button>
                    </div>
                    
                    <!-- Checkout / Total -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold fs-5">Total:</span>
                        <span id="total-nominal" class="fw-bold fs-4 text-success">Rp 0</span>
                    </div>
                    
                    <button type="button" onclick="copy_div();" class="btn btn-success w-100" id="btn-checkout" form="sale" data-toggle="modal" data-target="#confirmProductModal">Checkout</button>
                </div>

            </div>
        </div>
    </div>
</div>

</div>

<div class="modal fade" id="confirmProductModal" tabindex="-1" aria-labelledby="customProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customProductModalLabel">Summary</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="row">
            <div class="col-md-1">
                <label for="">Customer</label>
            </div>
            <div class="col-md-3">
                <select name="customer" id="customer_modal" onchange="muncul_cicil();" class="select2 form-control">
                    <option value="0">Pilih Customer / User Umum</option>
                @foreach($customers as $index => $c)
                    <option value="{{$c->id}}">{{$c->customer_phone}} - {{$c->customer_name}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-md-1 hidden_bank" style="display: none;">
                <label for="">Bank</label>
            </div>
            <div class="col-md-3 hidden_bank" style="display: none;">
                <select name="bank" id="bank" class="pilih2 form-control">
                    <option value="0">Pilih Bank</option>
                    @foreach($bank as $index => $b)
                    <option value="{{$b->id}}">{{$b->nama_bank}} - {{$b->no_akun}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 hidden_rekening" style="display: none;">
                <label for="">Rekening</label>
            </div>
            <div class="col-md-3 hidden_rekening" style="display: none;">
                <select name="rekening" id="rekening" class="pilih2 form-control">
                    <option value="0">Pilih Rekening</option>
                    @foreach($rekening as $index => $r)
                    <option value="{{$r->id}}">{{$r->nama_rekening}} - {{$r->no_rekening}}</option>
                    @endforeach
                </select>
            </div>
            
        </div>
        <div class="row mt-3">
            <div class="col-md-2">
                <label>
                    <input type="checkbox" name="cash" id="cash" onchange="rubah_disabled();" checked>
                    Cash
                </label>
                <input type="number" name="nominal_cash" id="nominal_cash" class="form-control" value="0" onkeyup="check_total();">
            </div>
            <div class="col-md-2">
                <label>
                    <input type="checkbox" name="transfer" id="transfer" onchange="rubah_disabled();">
                    Transfer
                </label>
                <input type="number" name="nominal_transfer" id="nominal_transfer" class="form-control" value="0" onkeyup="check_total();" disabled>
            </div>
            <div class="col-md-2">
                <label>
                    <input type="checkbox" name="edc" id="edc" onchange="rubah_disabled();">
                    EDC
                </label>
                <input type="number" name="nominal_edc" id="nominal_edc" class="form-control" value="0" onkeyup="check_total();" disabled>
            </div>
            <div class="col-md-2">
                <label>
                    <input type="checkbox" name="qr" id="qr" onchange="rubah_disabled();">
                    QR
                </label>
                <input type="number" name="nominal_qr" id="nominal_qr" class="form-control" value="0" onkeyup="check_total();" disabled>
            </div>
            <div class="col-md-2">
                <label>
                    <input type="checkbox" name="cc" id="cc" onchange="rubah_disabled();">
                    CC
                </label>
                <input type="number" name="muncul_cc" id="muncul_cc" class="form-control" value="0" disabled style="display:none;">
                <input type="number" name="nominal_cc" id="nominal_cc" class="form-control" value="0" onkeyup="check_total();" disabled style="color: red;">
            </div>
            <div class="col-md-2" id="div_cicil" style="display: none;">
                <label>
                    <input type="checkbox" name="cicil" id="cicil" onchange="rubah_disabled();">
                    Cicil
                </label>
                <input type="number" name="nominal_cicil" id="nominal_cicil" class="form-control" value="0" onkeyup="check_total();" disabled>
            </div>
        </div>
        <hr class="mt-3">
        
        <div class="mt-5" id="copy">

        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-bold fs-5">Total:</span>
            <span id="total" class="fw-bold fs-4 text-success">Rp 0</span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-bold fs-5">Total Pembayaran:</span>
            <span id="total-pembayaran" class="fw-bold fs-4 text-info">Rp 0</span>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" form="" class="btn btn-primary" onclick="submit_form();" id="submit_form" style="display: block;">submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Custom Product Modal -->
<div class="modal fade" id="customProductModal" tabindex="-1" aria-labelledby="customProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customProductModalLabel">Add Custom Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="custom-product-form">
          <div class="mb-3">
            <label class="form-label">Service</label>
            <input type="text" class="form-control" id="service" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Desc</label>
            <input type="text" class="form-control" id="desc" required>
            <!-- <textarea name="form-control" id="desc" name="desc" required>hello</textarea> -->
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" onkeyup="sum_harga();" required>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" form="custom-product-form" class="btn btn-primary">Add Product</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="tukar" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Tukar Tambah</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div>
                    <form action="/products_insert_luar" id="productForm" target="_blank" method="post">
                        @csrf
                        <input type="hidden" name="webcam" id="hasilcapture">
                        <div class="px-0 py-2">
                            @php
                                $number = 0;
                            @endphp
                            <div class="col-span-2 px-2">
                                <div class="flex flex-row grid grid-cols-2 gap-1">
                                    <div class="form-group">
                                        <div class="py-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="upload"
                                                    id="up2" checked>
                                                <label class="form-check-label" for="up2">Upload</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="upload"
                                                    id="up1">
                                                <label class="form-check-label" for="up1">Webcam</label>
                                            </div>
                                        </div>
                                        <div id="upload2" style="display: none !important;"
                                            class="align-items-center justify-content-center" wire:ignore>
                                            @livewire('webcam', ['key' => 0], key('cam-' . 0))
                                        </div>
                                        <div id="upload1" wire:ignore>
                                            <div class="form-group">
                                                <div class="dropzone d-flex flex-wrap align-items-center justify-content-center"
                                                    id="document-dropzone">
                                                    <div class="dz-message" data-dz-message>
                                                        <i class="bi bi-cloud-arrow-up"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('image'))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first('image') }}</small
                                                    class="text-danger">
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        $field_id = 'product_category_' . $number;
                                        ?>
                                        <label for="product_category" class="form-label d-block">Product Category</label>
                                        <select name="new_product_category_id" id="{{ $field_id }}" required
                                            class="form-control select2 @error('new_product.product_category_id') is-invalid @enderror">
                                            <option value="">Semua Produk</option>

                                            @foreach ($product_categories as $category)
                                                <option value="{{ $category->id }}"
                                                    code="{{ $category->category_code }}">
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.model_id';
                                        $field_id = 'model_'.$number;
                                        $field_lable = label_case('model');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = 'required';
                                        ?>
                                        <label for="{{ $field_name }}" class="form-label d-block">{{ $field_lable }}</label>
                                        <select class="form-control select2 @error($field_name) is-invalid @enderror"
                                            name="{{ $field_name }}" id="{{ $field_id }}" style="width: 100% !important ;" required>
                                            <option value="" selected disabled>Pilih Model</option>
                                            @foreach ($models as $model)
                                                <option value="{{ $model->id }}">
                                                    {{ $model->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.karat_id';
                                        $field_id = 'karat_' . $number;
                                        $field_lable = label_case('karat');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = 'required';
                                        ?>
                                        <label for="{{ $field_name }}" class="form-label d-block">@lang('Karat') <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2 @error($field_name) is-invalid @enderror"
                                            name="{{ $field_name }}" id="{{ $field_id }}" required>
                                            @foreach ($dataKarat as $karat)
                                                <option value="{{ $karat->id }}">{{ $karat->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.group_id';
                                        $field_id = 'group_' . $number;
                                        $field_lable = label_case('group');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = 'required';
                                        ?>
                                        <label for="{{ $field_name }}" class="form-label d-block">@lang($field_lable)
                                            <span class="text-danger">*</span>
                                            <span class="small">Jenis Perhiasan</span>
                                        </label>
                                        <select class="form-control select2 @error($field_name) is-invalid @enderror"
                                            name="{{ $field_name }}" id="{{ $field_id }}" required>
                                            <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.code';
                                        $field_id = 'code_' . $number;
                                        $field_lable = label_case('code');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = 'required';
                                        ?>
                                        <label for="{{ $field_name }}">{{ $field_lable }}<span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="hidden" name="temp_code" id="temp_code">
                                            <input type="text" id="{{ $field_id }}" name="new_product_code_id"
                                                class="form-control @error($field_name) is-invalid @enderror" readonly
                                                required>
                                            <span class="input-group-btn">
                                                <button class="btn btn-info relative rounded-l-none"
                                                    onclick="gencode({{ $number }});" type="button">Check</button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.harga';
                                        $field_id = 'harga_' . $number;
                                        $field_lable = label_case('harga');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = 'required';
                                        ?>
                                        <label for="{{ $field_name }}">{{ $field_lable }}<span
                                                class="text-danger">*</span></label>
                                        <input type="number" id="{{ $field_id }}" name="new_product_harga"
                                            class="form-control " required>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Payment</label>
                                        <select name="payment" id="payment" class="form-control">
                                            <option value="cash">Cash</option>
                                            <option value="transfer">Transfer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.keterangan';
                                        $field_id = 'keterangan_' . $number;
                                        $field_lable = label_case('keterangan');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = 'required';
                                        ?>
                                        <label for="{{ $field_name }}">{{ $field_lable }}<span
                                                class="text-danger">*</span></label>
                                        <textarea id="{{ $field_id }}" name="new_product_keterangan" class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        $field_name = 'new_product.berat';
                                        $field_id = 'berat_' . $number;
                                        $field_lable = label_case('berat');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = 'required';
                                        ?>
                                        <label for="{{ $field_name }}">{{ $field_lable }} (gram)<span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="{{ $field_id }}" name="new_product_berat"
                                            class="form-control " required>
                                        <!-- <div class="input-group">
                                                    </div> -->
                                    </div>

                                </div>

                                {{-- ///batas --}}

                            </div>
                            <button class="btn btn-success" onclick="return alert('Proses ?');">Submit</button>
                    </form>
                </div>
            
                <div> 
                    <form action="/buyback_insert" target="_blank" method="post">
                        @csrf
                        {{-- <div class="form-group">
                            <label for="">Code Product</label>
                            <input type="text" class="form-control" name="product" required>
                        </div> --}}
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">No Nota</label>
                                    <input type="hidden" name="product" id="product">
                                    <input type="text" class="form-control" name="nota" id="nota"
                                        onkeyup="view_nota();" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Kondisi</label>
                                    <input type="text" class="form-control" name="kondisi" id="kondisi" required
                                        readonly>
                                </div>
                            </div>
    
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="">Payment</label>
                                    <select name="payment" id="payment" class="form-control">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
    
                            </div>
    
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="" id="label_potongan">Max Harga Potongan : </label>
                                    <input type="number" class="form-control" potongan=""
                                        name="potongan" id="potongan" onkeyup="change_harga();" required
                                        value="0">
                                </div>
                            </div>
    
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="" id="label_tambahan">Max Harga Tambahan : </label>
                                    <input type="number" class="form-control" tambahan=""
                                        name="tambahan" id="tambahan" onkeyup="change_harga();" required
                                        value="0">
                                </div>
                            </div>
    
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="" id="label_manual">Input Harga Manual : </label>
                                    <input type="number" class="form-control" 
                                        name="manual" id="manual" onkeyup="change_harga();" required
                                        value="0">
                                </div>
                            </div>
    
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Harga : </label>
                                    <input type="hidden" name="harga_awal" id="harga_awal">
                                    <input type="hidden" name="harga" id="harga">
                                    <input type="text" class="form-control" name="harga_label" id="harga_label"
                                        value="0" readonly>
                                </div>
                            </div>
    
                            
    
                            <div class="col-12 mt-5">
                                <table class="invoice-table" id="invoice-table" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Img</th>
                                            <th>Kode</th>
                                            <th>Jenis</th>
                                            <th>Deskripsi</th>
                                            <th>Berat</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img id="t_image" src="./storage/uploads/1742774180.png" order="0"
                                                    width="70" class="img-thumbnail"></td>
                                            <td id="t_kode">Emas Dummy</td>
                                            <td id="t_jenis">Emas Antam</td>
                                            <td id="t_desc">Gold 1 ml Ruth</td>
                                            <td id="t_berat">1 g</td>
                                            <td id="t_harga">Rp. 9.999.999</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
    
                        <br>
                        <button type="button" class="btn btn-sm btn-success" id="btn_submit" style="display: none;">Submit</button>
                        <button type="submit" class="btn btn-sm btn-success" form="tukar-product-form">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

@push('page_scripts')
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
<script src="{{ asset('js/dropzone.js') }}"></script>


<!-- Bootstrap JS (with Popper) – CDN version -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AHR5oKn06PWzGk+E9Y1kCfmhktbZ5d9+8wCjUY8H7Sk/9kccB+ApPBALSczF+" crossorigin="anonymous"></script> -->
    <script> 

    function addProductLuarToCart(data) {
    const previewArea = $('#preview-area');

    const newItem = `
        <div class="border-bottom pb-2 mb-2 preview-item tukar-item">
            <div class="row align-items-center">
                <div class="col-2">
                    <h6 class="mb-0 small text-danger">${data.product_name}</h6>
                    <small>${data.product_desc || ''}</small>
                </div>
                <div class="col-3">
                    <small>Potongan: <strong>- ${data.harga}</strong></small>
                </div>
                <div class="col-2">
                    <input type="number" name="diskon[]" class="form-control form-control-sm" value="0" readonly>
                </div>
                <div class="col-2">
                    <input type="number" name="ongkos[]" class="form-control form-control-sm" value="0" readonly>
                </div>
                <div class="col-2">
                    <input type="number" name="harga[]" class="form-control form-control-sm tukar-harga"
                           data-original-harga="${data.harga}" value="${data.harga}" readonly>
                </div>
                <div class="col-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-current">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

    previewArea.append(newItem);
    sum_harga(); // recalc total
}



    function change_harga() {
            let awal = parseInt($("#harga_awal").val()) || 0;
            let manual = $("#manual");
            let potongan = $("#potongan");
            let tambahan = $("#tambahan");
            let tambahanPercent = parseFloat($('#tambahan').attr('tambahan')) || 0;
            let maxTambahan = awal * tambahanPercent / 100;
            let potonganPercent = parseFloat($('#potongan').attr('potongan')) || 0;
            let maxPotongan = awal * potonganPercent / 100;

            if (potongan.val() > maxPotongan) {
                potongan.val(maxPotongan);
            }
            if (tambahan.val() > maxTambahan) {
                tambahan.val(maxTambahan);
            }

            // ambil nilai input
            let potonganVal = parseInt(potongan.val()) || 0;
            let tambahanVal = parseInt(tambahan.val()) || 0;
            let manualVal   = parseInt(manual.val())   || 0;

            let harga = awal;

            // case: potongan > 0
            if (potonganVal > 0) {
                tambahan.val(0).prop("disabled", true).prop("readonly", true);
                manual.val(0).prop("disabled", true).prop("readonly", true);

                harga = awal - potonganVal;
            }
            // case: tambahan > 0
            else if (tambahanVal > 0) {
                potongan.val(0).prop("disabled", true).prop("readonly", true);
                manual.val(0).prop("disabled", true).prop("readonly", true);

                harga = awal + tambahanVal;
            }
            // case: manual > 0
            else if (manualVal > 0) {
                potongan.val(0).prop("disabled", true).prop("readonly", true);
                tambahan.val(0).prop("disabled", true).prop("readonly", true);

                harga = manualVal;
            }
            // kalau semua kosong / 0 → aktifkan semua lagi
            else {
                potongan.prop("disabled", false).prop("readonly", false);
                tambahan.prop("disabled", false).prop("readonly", false);
                manual.prop("disabled", false).prop("readonly", false);
            }

            // update field harga
            $("#harga").val(harga);
            $("#harga_label").val("Rp " + harga.toLocaleString("id-ID"));
        }


        function view_nota() {
            $("#btn_submit").hide();
            $('#invoice-table').hide();

            let nota = $('#nota').val();
            let length = nota.length;
            $('#potongan').val(0);
            $('#tambahan').val(0);
            $('#kondisi').prop('readonly', true);

            if (length > 9) {
                $('#t_image').html();
                $('#t_kode').html();
                $('#t_jenis').html();
                $('#t_desc').html();
                $('#t_berat').html();
                $('#t_harga').html();
                $.ajax({
                    url: '/buyback_nota/' + nota, // The URL for your route
                    type: 'GET', // Request method
                    dataType: 'json', // Expecting JSON response
                    success: function(response) {
                        // On success, handle the response
                        if (response) {
                            if (response.harga !== '') {
                                let price = parseInt(response.price);
                                let rupiah = 'Rp ' + price.toLocaleString('id-ID');
                                let tambahanPercent = parseFloat($('#tambahan').attr('tambahan')) || 0;
                                let maxTambahan = price * tambahanPercent / 100;
                                let potonganPercent = parseFloat($('#potongan').attr('potongan')) || 0;
                                let maxPotongan = price * potonganPercent / 100;
                                let rupiahMaxPotongan = 'Rp ' + maxPotongan.toLocaleString('id-ID');
                                let rupiahMaxTambahan = 'Rp ' + maxTambahan.toLocaleString('id-ID');

                                $('#potongan').attr('max', maxPotongan);
                                $('#label_potongan').html('Potongan Max ' + potonganPercent + '% : ' +
                                    rupiahMaxPotongan);
                                $('#tambahan').attr('max', maxTambahan);
                                $('#label_tambahan').html('Tambahan Max ' + tambahanPercent + '% : ' +
                                    rupiahMaxTambahan);

                                $('#kondisi').prop('readonly', false);

                                $('#product').val(response.product);

                                $('#harga').val(price);
                                $('#t_image').attr('src', '/storage/uploads/' + response.image);
                                $('#t_kode').html(response.kode);
                                $('#t_jenis').html(response.jenis);
                                $('#t_desc').html(response.desc);
                                $('#t_berat').html(response.berat);
                                $('#t_harga').html(rupiah);
                                $('#harga_label').val(rupiah);
                                $('#harga_awal').val(price);
                                $('#btn_submit').show();
                                $('#invoice-table').show();
                            } else {
                                alert('Nota not valid');
                            }
                        } else {
                            // $("#result").html("<p>No data found.</p>");
                        }
                    },
                    error: function() {
                        // Handle errors
                        alert('An error occurred.');
                    }
                });
            }
        }

        function gencode(number) {
            console.log(number);
            let rand = Math.floor(Math.random() * 1000);
            let group = $('#group_' + number).find('option:selected').text();
            group = group.substring(0, 1);
            let categoryCode = $('#product_category_' + number).find('option:selected').attr('code');

            let karat = $('#karat_' + number).find('option:selected').text();
            karat = karat.split('|')[0]?.trim();
            let date = new Date();
            let formattedDate = ("0" + date.getDate()).slice(-2) + ("0" + (date.getMonth() + 1)).slice(-2) + date
                .getFullYear().toString().slice(-2);
            let temp_code = categoryCode + karat + formattedDate + rand;
            $("#temp_code").val(temp_code);

            const now = new Date();

            const datePart = now.toISOString().split('T')[0]; // "2025-06-18"
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');

            const formatted = `${datePart} ${hours}.${minutes}`;
            const input = formatted.replace(/[-.:\s]/g, '');

            console.log(formatted);

            let code = 'BL' + input;
            $("#code_" + number).val(code);
        }

    $(document).ready(function() {
        $('#customer_modal').select2({
            dropdownParent: $('#confirmProductModal'),
            placeholder: "Pilih Customer",
            allowClear: true
        });
        $('#product_category_0').select2({
            dropdownParent: $('#tukar'),
            placeholder: "Pilih kategori produk",
            allowClear: true
        });

        $('#model_0').select2({
            // width: '300px',
            // width: 'resolve',
            width: '350px',  
            // width: '100%',
            dropdownParent: $('#tukar'),
            placeholder: "Pilih Model",
            allowClear: true
        });

        $('#karat_0').select2({
            dropdownParent: $('#tukar'),
            placeholder: "Pilih Karat",
            allowClear: true
        });

        $('#group_0').select2({
            dropdownParent: $('#tukar'),
            placeholder: "Pilih Group",
            allowClear: true
        });

        $('#productForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            const productName  = $('#product_category_0 option:selected').text();
            const modelName    = $('#model_0 option:selected').text();
            const karat        = $('#karat_0 option:selected').text();
            const group        = $('#group_0 option:selected').text();
            const code         = $('#code_0').val();
            const harga        = $('#harga_0').val();
            const keterangan   = $('#keterangan_0').val();
            const berat        = $('#berat_0').val();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    // ✅ after insert success, add to cart preview
                    addProductLuarToCart(
                        {
                            product_name: productName,
                            product_desc: `${modelName} - ${karat} - ${group} - ${keterangan}`,
                            harga: harga,
                            code: code,
                            berat: berat
                        }
                    );

                    // reset form + close modal
                    $('#productForm')[0].reset();
                    // $('#tukar').modal('hide');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal menyimpan Produk Luar');
                }
            });
        });
    });
    
    function getIntVal(id) {
        let val = $("#" + id).val();
        return val ? parseInt(val) || 0 : 0;
    }

    function muncul_cicil(){
        let customer    = $("#customer_modal").val();
        if(customer == 0){
            $("#div_cicil").hide();
            $("#nominal_cicil").val(0);
            $("#cicil").prop('checked', false);
        }else{
            $("#div_cicil").show();
        }
    }

    function check_total(){
        let isCcChecked         = $('#cc').prop('checked');
        let isCicilChecked      = $('#cicil').prop('checked');
        let nominal_cash        = getIntVal('nominal_cash');
        let nominal_edc         = getIntVal('nominal_edc');
        let nominal_transfer    = getIntVal('nominal_transfer');
        let nominal_qr          = getIntVal('nominal_qr');
        let nominal_cc          = getIntVal('nominal_cc');
        let nominal_cicil       = getIntVal('nominal_cicil');

        if(isCcChecked){
            let persenCc            = $("#persen_cc").val();
            let total               = $("#total-nominal").html();
            const nilai = parseInt(total.replace(/[^\d]/g, ''), 10);

            let semua   = nominal_cash+nominal_edc+nominal_transfer+nominal_qr+nominal_cicil;
            // console.log(semua);
            let sisa    = nilai-semua;
            // console.log(sisa);
            $("#muncul_cc").show();
            $("#muncul_cc").val(sisa);
            $('#nominal_cc').val(sisa+(sisa*persenCc/100));
        }else{
            $('#nominal_cc').val(0);
            $('#muncul_cc').val(0);
        }

        if(isCicilChecked){
            let total               = $("#total-nominal").html();
            const nilai = parseInt(total.replace(/[^\d]/g, ''), 10);

            let semua   = nominal_cash+nominal_edc+nominal_transfer+nominal_qr+nominal_cc;
            let sisa    = nilai-semua;
            $('#nominal_cicil').val(sisa);
        }else{
            $('#nominal_cicil').val(0);
        }

        let muncul_cc           = getIntVal('muncul_cc');
        let muncul_cicil        = getIntVal('nominal_cicil');

        let kabeh   = nominal_cash+nominal_edc+nominal_transfer+nominal_qr+muncul_cc+muncul_cicil;
        let total   = $("#total").html(); // Rp 1.405.000
        let totalInt = parseInt(total.replace(/[^0-9]/g, '')); // "1405000" → 1405000
        let total_pembayaran    = nominal_cash+nominal_edc+nominal_transfer+nominal_qr+muncul_cc+muncul_cicil;
        console.log(muncul_cicil);
        console.log(total_pembayaran);
        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(total_pembayaran);
        $("#total-pembayaran").html(formatted);
        if(totalInt == kabeh){
            $("#submit_form").show();
        }else{
            $("#submit_form").hide();
        }
    }

    function rubah_disabled() {
        check_total();
        let isCashChecked     = $('#cash').prop('checked');
        let isEdcChecked      = $('#edc').prop('checked');
        let isTransferChecked = $('#transfer').prop('checked');
        let isQrChecked = $('#qr').prop('checked');
        let isCcChecked = $('#cc').prop('checked');
        let isCicilChecked = $('#cicil').prop('checked');
        let persenCc = $("#persen_cc").val();

        if(isCashChecked){
            // $(".hidden_rekening").show();
        }else{
            // $(".hidden_rekening").hide();
            $('#nominal_cash').val(0);
        }
        if(isEdcChecked){
            $(".hidden_rekening").show();
        }else{
            $(".hidden_rekening").hide();
            $('#nominal_edc').val(0);
        }
        if(isTransferChecked){
            $(".hidden_bank").show();
        }else{
            $(".hidden_bank").hide();
            $('#nominal_transfer').val(0);
        }
        if(isQrChecked){
            // $(".hidden_rekening").show();
        }else{
            // $(".hidden_rekening").hide();
            $('#nominal_qr').val(0);
        }

        let nominal_cash        = getIntVal("nominal_cash");
        let nominal_edc         = getIntVal("nominal_edc");
        let nominal_transfer    = getIntVal("nominal_transfer");
        let nominal_qr          = getIntVal("nominal_qr");
        let nominal_cc          = getIntVal("nominal_cc");
        let nominal_cicil       = getIntVal("nominal_cicil");
        let total               = $("#total-nominal").html();
        const nilai = parseInt(total.replace(/[^\d]/g, ''), 10);
        
        if(isCcChecked){
            let semua   = nominal_cash+nominal_edc+nominal_transfer+nominal_qr+nominal_cicil;
            let sisa    = nilai-semua;
            $("#muncul_cc").show();
            $("#muncul_cc").val(sisa);
            $('#nominal_cc').val(sisa+(sisa*persenCc/100));
        }else{
            $('#nominal_cc').val(0);
        }

        if(isCicilChecked){
            let semua   = nominal_cash+nominal_edc+nominal_transfer+nominal_qr+nominal_cc;
            let sisa    = nilai-semua;
            $('#nominal_cicil').val(sisa);
        }else{
            $('#nominal_cicil').val(0);
        }
        
        $('#nominal_cash').prop('disabled', !isCashChecked);
        $('#nominal_edc').prop('disabled', !isEdcChecked);
        $('#nominal_transfer').prop('disabled', !isTransferChecked);
        $('#nominal_qr').prop('disabled', !isQrChecked);
        let muncul_cc          = getIntVal("muncul_cc");

        let total_pembayaran    = nominal_cash+nominal_edc+nominal_transfer+nominal_qr+muncul_cc+nominal_cicil;
        console.log(nominal_cash);
        console.log(nominal_edc);
        console.log(nominal_transfer);
        console.log(nominal_qr);
        console.log(muncul_cc);
        console.log(total_pembayaran);
        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(total_pembayaran);
        $("#total-pembayaran").html(formatted);
        // $('#nominal_cc').prop('disabled', !isCcChecked);
        
        // console.log(totalInt); // 1405000
    }

    $(document).ready(function(){
        $('.pilih2').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
        $('#confirmProductModal').on('hidden.bs.modal', function () {
            remove_copy();
        });
    });

    function submit_form(){
        let cust = $("#customer_modal").val();
        let cash = $("#nominal_cash").val();
        let edc = $("#nominal_edc").val();
        let transfer = $("#nominal_transfer").val();
        let qr = $("#nominal_qr").val();
        let cc = $("#nominal_cc").val();
        let cicil = $("#nominal_cicil").val();
        let muncul_cc = $("#muncul_cc").val();
        let bank = $("#bank").val();
        let rekening = $("#rekening").val();
        $("#customer").val(cust);
        $("#hidden_cash").val(cash);
        $("#hidden_edc").val(edc);
        $("#hidden_transfer").val(transfer);
        $("#hidden_qr").val(qr);
        $("#hidden_cc").val(cc);
        $("#hidden_muncul_cc").val(muncul_cc);
        $("#hidden_cicil").val(cicil);
        $("#hidden_bank").val(bank);
        $("#hidden_rekening").val(rekening);

        $("#sale").attr("target", "_blank").submit();
        setTimeout(function() {
            location.reload();
        }, 5000);
        // $("#sale").submit();
        // return true;
    }

    function copy_div(){
        let clone = $("#preview-area").clone();

        // For each diskon input inside the clone, set the 'value' attribute to the current input value
        clone.find('input[name="diskon[]"]').each(function(){
            $(this).attr('value', $(this).val());
        });

        clone.find('input[name="ongkos[]"]').each(function(){
            $(this).attr('value', $(this).val());
        });

        // Similarly, for each harga input inside the clone, update the 'value' attribute
        clone.find('input[name="harga[]"]').each(function(){
            $(this).attr('value', $(this).val());
        });

        // Remove unwanted elements in the clone
        // clone.find('input[name="diskon[]"]').remove();       // If you want to remove discount inputs in the copy
        clone.find('.btn-delete-current').remove();          // Remove delete buttons from copy

        // Now set the HTML of #copy using the clone's HTML
        $("#copy").html(clone.html());
        let total = $("#total-nominal").html();
        $("#total").html(total);
        const nilai = parseInt(total.replace(/[^\d]/g, ''), 10);
        // console.log(value); // 2681000

        let nominal_cash        = getIntVal('nominal_cash');
        let nominal_edc         = getIntVal('nominal_edc');
        let nominal_transfer    = getIntVal('nominal_transfer');
        let nominal_qr          = getIntVal('nominal_qr');
        let nominal_cc          = getIntVal('muncul_cc');
        
        if(nominal_cash == 0){
            $("#nominal_cash").val(nilai);
        }else{
            $("#nominal_cash").val(nominal_cash);
        }    

        let nominal_cash2       = getIntVal('nominal_cash');

        let kabeh   = nominal_cash2+nominal_edc+nominal_transfer+nominal_qr+nominal_cc;

        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(kabeh);

        $("#total-pembayaran").html(formatted);

        let total_new   = $("#total").html(); // Rp 1.405.000
        let totalInt = parseInt(total_new.replace(/[^0-9]/g, '')); // "1405000" → 1405000
        let total_pembayaran    = nominal_cash2+nominal_edc+nominal_transfer+nominal_qr+muncul_cc;
        
        if(totalInt == kabeh){
            $("#submit_form").show();
        }else{
            $("#submit_form").hide();
        }
    }

    function copy_div_old(){
        // $('input[name="diskon[]"]').prop('readonly', true);
        let div = $("#preview-area").html();
        let total = $("#total-nominal").html();
        $("#copy").html(div);
        $("#total").html(total);
        $('#copy input[name="diskon[]"]').remove();
        $('#copy .btn-delete-current').remove();
    }     
    function remove_copy(){
        // $('input[name="diskon[]"]').prop('readonly', false);
        $("#copy").html('');
    }
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        lengthChange: true,
        searching: true,
        "oLanguage": {
            "sSearch": "<i class='bi bi-search'></i> {{ __("labels.table.search") }} : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per {{ __("labels.table.page") }} ",
            "sInfo": "{{ __("labels.table.showing") }} _START_ s/d _END_ {{ __("labels.table.from") }} <b>_TOTAL_ data</b>",
            "sInfoFiltered": "(filter {{ __("labels.table.from") }} _MAX_ total data)",
            "sZeroRecords": "{{ __("labels.table.not_found") }}",
            "sEmptyTable": "{{ __("labels.table.empty") }}",
            "sLoadingRecords": "Harap Tunggu...",
            "oPaginate": {
                "sPrevious": "{{ __("labels.table.prev") }}",
                "sNext": "{{ __("labels.table.next") }}"
            }
        },

        "aaSorting": [[ 0, "desc" ]],
        "columnDefs": [
        {
            "targets": 'no-sort',
            "orderable": false,
        }
        ],
        "sPaginationType": "simple_numbers",
        ajax: '/sale/index_data',
        dom: 'lfrtip',
        // dom: 'Blfrtip',
        columns: [{
            "data": 'id',
            "sortable": false,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            data: 'product_image',
            name: 'product_image'
        }, {
            data: 'product_code',
            name: 'product_code'
        }, {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'karat',
            name: 'karat'
        }, 
        {
            data: 'rekomendasi',
            name: 'rekomendasi'
        }, 

        // {
        //     data: 'rounded',
        //     name: 'rounded'
        // }, 
        // {
        //     data: 'created_at',
        //     name: 'created_at'
        // },
        {
            data: null,
            className: 'text-center',
            render: function(data, type, row, meta) {
                return `<button class="btn btn-sm btn-success btn-add-to-preview" data-row='${JSON.stringify(row)}'>Add</button>`;
            }
        },

        // {
        //     data: 'action',
        //     name: 'action',
        //     orderable: false,
        //     searchable: false
        // }
        ]
    })
    .buttons()
    .container()
    .appendTo("#buttons"); 
    
    function sum_harga_old(){
        let total = 0;

        $('input[name="harga[]"]').each(function () {
            const value = parseFloat($(this).val());

            if (!isNaN(value)) {
                total += value;
            }
        });

        // Format and update total display
        $('#total-nominal').text(`Rp ${formatRupiah(total)}`);
    }

    function sum_harga() {
    let total = 0;

    // loop all harga inputs
    $('input[name="harga[]"]').each(function () {
        const value = parseFloat($(this).val());
        if (isNaN(value)) return;

        if ($(this).hasClass('tukar-harga')) {
            total -= value; // subtract tukar tambah item
        } else {
            total += value; // add normal item
        }
    });

    // Format and update total display
    $('#total-nominal').text(`Rp ${formatRupiah(total)}`);
}

    function sum_diskon() {
        const ongkosInputs = document.querySelectorAll('input[name="ongkos[]"]');
        const diskonInputs = document.querySelectorAll('input[name="diskon[]"]');
        const hargaInputs = document.querySelectorAll('input[name="harga[]"]');

        diskonInputs.forEach((diskonInput, index) => {
            const hargaInput = hargaInputs[index];
            const ongkosInput = parseInt(ongkosInputs[index].value) || 0;
            console.log(ongkosInput);
            if (!hargaInput) return;

            const originalHarga = parseInt(hargaInput.getAttribute('data-original-harga')) || 0;
            let diskonVal = parseInt(diskonInput.value) || 0;

            // Ensure discount is not negative or above max
            if (diskonVal < 0) diskonVal = 0;
            const maxDiskon = parseInt(diskonInput.getAttribute('max')) || diskonVal;
            if (diskonVal > maxDiskon) {
            diskonVal = maxDiskon;
            diskonInput.value = maxDiskon; // correct the input value
            }

            // Calculate the new harga after discount
            let newHarga = originalHarga - diskonVal + ongkosInput;
            // let newHarga = originalHarga - diskonVal;
            if (newHarga < 0) newHarga = 0; // prevent negative harga

            hargaInput.value = newHarga;
        });
        sum_harga();
    }

    function sum_ongkos() {
        const ongkosInputs = document.querySelectorAll('input[name="ongkos[]"]');
        const diskonInputs = document.querySelectorAll('input[name="diskon[]"]');
        const hargaInputs = document.querySelectorAll('input[name="harga[]"]');

        ongkosInputs.forEach((ongkosInput, index) => {
            const hargaInput = hargaInputs[index];
            const diskonInput = parseInt(diskonInputs[index].value) || 0;
            console.log(diskonInput);
            if (!hargaInput) return;

            const originalHarga = parseInt(hargaInput.getAttribute('data-original-harga')) || 0;
            let ongkosVal = parseInt(ongkosInput.value) || 0;

            // Ensure discount is not negative or above max
            // if (diskonVal < 0) diskonVal = 0;
            // const maxDiskon = parseInt(ongkosInput.getAttribute('max')) || diskonVal;
            // if (diskonVal > maxDiskon) {
            // diskonVal = maxDiskon;
            // ongkosInput.value = maxDiskon; // correct the input value
            // }

            // Calculate the new harga after discount
            let newHarga = originalHarga + ongkosVal - diskonInput;
            if (newHarga < 0) newHarga = 0; // prevent negative harga

            hargaInput.value = newHarga;
        });
        sum_harga();
    }

    function formatRupiah(number) {
        return number.toLocaleString('id-ID');
    }

    $('#btn-delete-last').on('click', function () {
        const previewArea = $('#preview-area');
        const lastItem = previewArea.children().last();

        if (lastItem.length) {
            lastItem.remove();
        } else {
            alert('No items to delete!');
        }
        sum_harga();
    });

    $(document).on('click', '.btn-delete-current', function () {
        $(this).closest('.preview-item').remove();
        sum_harga();
    });


    $('#custom-product-form').on('submit', function (e) {
        e.preventDefault();

        const service   = $('#service').val().trim();
        const desc      = $('#desc').val().trim();
        // const harga     = formatRupiah(parseFloat($('#harga').val()));
        const harga     = (parseFloat($('#harga').val()));
        const price     = $('#harga').val();
        const diskon    = $('#diskon').val();
        const min       = price-diskon;
        
        if (!service || isNaN(harga)) {
            alert("Please fill out the form correctly.");
            return;
        }

        const previewArea = $('#preview-area');

        const newItem = `
            <div class="border-bottom pb-2 mb-2 preview-item">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="text-xs text-blue-600">${service}</div>
                        <h6 class="mb-0 small text-gray-700">${desc}</h6>
                    </div>
                    <div class="col-3">
                        <small>Harga: <strong>${harga}</strong></small>
                    </div>
                    <div class="col-2">
                        <input type="number" name="diskon[]" class="form-control form-control-sm" value="0" max="0" readonly>
                    </div>
                    <div class="col-2">
                        <input type="number" name="ongkos[]" class="form-control form-control-sm" value="0" max="0" readonly>
                    </div>
                    <div class="col-2">
                        <input type="hidden" name="product[]" value="0">
                        <input type="hidden" name="product_name[]" value="${service}">
                        <input type="hidden" name="product_desc[]" value="${desc}">
                        <input type="number" name="harga[]" class="form-control form-control-sm" data-original-harga="${price}" onkeyup="sum_harga();" value="${price}" placeholder="Harga" readonly>
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-current">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        previewArea.append(newItem);
        sum_harga();

        // Reset and hide modal
        $('#custom-product-form')[0].reset();
        // const modalEl = document.getElementById('customProductModal');
        // const modal = bootstrap.Modal.getInstance(modalEl);
        // modal.hide();
    });

    $('#tukar-product-form').on('submit', function (e) {
        e.preventDefault();

        const service   = $('#tukar_product').val().trim();
        const desc      = $('#tukar_desc').val().trim();
        // const harga     = formatRupiah(parseFloat($('#harga').val()));
        const harga     = (parseFloat($('#tukar_harga').val()));
        const price     = $('#tukar_harga').val();
        const diskon    = $('#diskon').val();
        const min       = price-diskon;
        
        if (!service || isNaN(harga)) {
            alert("Please fill out the form correctly.");
            return;
        }

        const previewArea = $('#preview-area');

        const newItem = `
            <div class="border-bottom pb-2 mb-2 preview-item">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="text-xs text-red-600">${service}</div>
                        <h6 class="mb-0 small text-gray-700">${desc}</h6>
                    </div>
                    <div class="col-3">
                        <small>Harga: <strong>${harga}</strong></small>
                    </div>
                    <div class="col-2">
                        <input type="number" name="diskon[]" class="form-control form-control-sm" value="0" max="0" readonly>
                    </div>
                    <div class="col-2">
                        <input type="number" name="ongkos[]" class="form-control form-control-sm" value="0" max="0" readonly>
                    </div>
                    <div class="col-2">
                        <input type="hidden" name="product[]" value="0">
                        <input type="hidden" name="product_name[]" value="${service}">
                        <input type="hidden" name="product_desc[]" value="${desc}">
                        <input type="number" name="harga[]" class="form-control form-control-sm" data-original-harga="${price}" onkeyup="sum_harga();" value="${price}" placeholder="Harga" readonly>
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-current">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        previewArea.append(newItem);
        sum_harga();

        // Reset and hide modal
        $('#tukar-product-form')[0].reset();
        // const modalEl = document.getElementById('customProductModal');
        // const modal = bootstrap.Modal.getInstance(modalEl);
        // modal.hide();
    });

    $(document).on('click', '.btn-add-to-preview', function() {
        let rowData = $(this).attr('data-row');
    
        try {
            // console.log(rowData);
            rowData = JSON.parse(rowData);
            renderPreview(rowData);
        } catch (e) {
            console.error('Failed to parse row data', e);
        }
    });

    function renderPreview(data) {
        const previewArea = $('#preview-area');
        const setHarga    = data.harga;
        const type        = data.karats.type;
        const group_id    = data.group_id;
        const product_price    = data.product_price;
        const har         = data.karats.harga;
        const hargaSilver = data.hargaSilver;
        const coef        = data.karats.coef;
        const margin      = data.karats.persen/100;
        const roundAwal   = Math.ceil(setHarga*coef / 1000) * 1000;
        const persen      = (roundAwal*margin)+roundAwal;
        const roundPersen = Math.ceil(persen / 1000) * 1000;
        const berat       = data.berat_emas;
        let   harga       = Math.ceil(roundPersen*berat / 1000) * 1000;
        if(type == 'LM'){
            // let result = value.split(",")[0];
            harga   = har.split(",")[0];
            harga   = harga.split(".")[0];
        }

        if(type == 'SILVER'){
            if(group_id == 31){
                harga   = hargaSilver*berat*coef;
            }else if(group_id == 32){
                harga   = product_price;
            }
            // let result = value.split(",")[0];
            // harga   = har.split(",")[0];
            // harga   = harga.split(".")[0];
        }
        const rekomendasi = formatRupiah(harga);
        const price       = (harga);
        const diskon      = Math.round((data.karats.diskon)*data.berat_emas);
        const min         = (price-diskon);
        const product     = (data.id);
        const newItem = `
        <div class="border-bottom pb-2 mb-2 preview-item">
            <div class="row align-items-center">
                <div class="col-2">
                    <h6 class="mb-0 small text-gray-700">${data.product_name}</h6>
                </div>
                <div class="col-2">
                    <small>Harga: <strong>${rekomendasi}</strong></small>
                </div>
                <div class="col-1">
                    <small>Max Disc: <strong>${diskon}</strong></small>
                </div>
                <div class="col-2">
                    <label>Disc</label>
                    <input type="number" name="diskon[]" class="form-control form-control-sm" value="0" max="${diskon}" onkeyup="sum_diskon();" placeholder="Diskon">
                </div>
                <div class="col-2">
                    <label>Ongkos</label>
                    <input type="number" name="ongkos[]" class="form-control form-control-sm" value="0" onkeyup="sum_ongkos();" placeholder="Diskon">
                </div>
                <div class="col-2">
                    <input type="hidden" name="product[]" value="${product}">
                    <input type="hidden" name="product_name[]" value="${data.category.category_name}">
                    <input type="hidden" name="product_desc[]" value="${data.category.category_name}">
                    <input type="number" name="harga[]" class="form-control form-control-sm" data-original-harga="${price}" value="${price}" onkeyup="sum_harga();" placeholder="Harga" readonly>
                </div>
                <div class="col-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-current">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>`;

        previewArea.append(newItem);
        sum_harga();
    }
        $(document).ready(function () {
            // $('#checkoutModal').modal('show');
            window.addEventListener('showCustomModal', event => {
                $('#customModal').modal('show');
            });
            window.addEventListener('showCheckoutModal', event => {
                $('#checkoutModal').modal('show');
            });
            window.addEventListener('cart:empty', event => {
                toastr.error(event.detail.message);
            });
            window.addEventListener('total_payment_amount', event => {
                toastr.error(event.detail.message);
            });
        });

        // WEBCAM

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
                console.log('uploaded');
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                uploadedDocumentMap[file.name] = response.name;
                Livewire.emit('imageUploaded', response.name);
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
                Livewire.emit('imageRemoved', name);
            },
            init: function() {
                @if (isset($product) && $product->getMedia('pembelian'))
                    var files = {
                        !!json_encode($product - > getMedia('pembelian')) !!
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
            $('#imageprev0').attr('src', '');
        });
        window.addEventListener('uploaded-image:remove', event => {
            Dropzone.forElement("div#document-dropzone").removeAllFiles(true);
        });
        $('#up1').change(function() {
            $('#upload2').toggle();
            $('#upload1').hide();
        });
        $('#up2').change(function() {
            $('#upload1').toggle();
            $('#upload2').hide();
        });

        function configure() {
            Webcam.set({
                width: 340,
                height: 230,
                autoplay: false,
                image_format: 'jpeg',
                jpeg_quality: 90,
                force_flash: false
            });
            Webcam.attach('#camera');
            $("#camera").attr("style", "display:block")
            $('#hasilGambar').addClass('d-none');
            $('#Start').addClass('d-none');
            $('#snap').removeClass('d-none');
        }
        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = false;
        shutter.src = navigator.userAgent.match(/Firefox/) ? asset('js/webcamjs/shutter.ogg') : asset(
            'js/webcamjs/shutter.mp3');

        function take_snapshot() {
            // play sound effect
            shutter.play();
            // take snapshot and get image data
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                $("#camera").attr("style", "display:none")
                $('#hasilGambar').removeClass('d-none').delay(5000);
                document.getElementById('hasilGambar').innerHTML =
                    '<img class="border-2 border-dashed border-yellow-600 rounded-xl" id="imageprev" src="' +
                    data_uri + '"/><span class="absolute bottom-1 text-white right-4">Capture Sukses..!! </span>';
                $('#snap').addClass('d-none');
                $('#Start').removeClass('d-none');


            });
            Webcam.reset();
        }

        function reset() {
            Webcam.reset();
            alert('off');
        }

        function saveSnap() {
            // Get base64 value from <img id='imageprev'> source
            var base64image = document.getElementById("imageprev").src;

            Webcam.upload(base64image, 'upload.php', function(code, text) {
                console.log('Save successfully');
                //console.log(text);
            });

        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


@endpush
