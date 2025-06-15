<div class="modal fade" id="pembayaran_dp" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Pembayaran DP</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form wire:submit.prevent="store">
                    <div class="grid grid-cols-2 gap-10">
                        <div class="col-span-2">
                            <div class="card">
                                <div class="card-header">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex relative py-1">
                                            <div class="relative flex justify-left">
                                                <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Informasi barang DP <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                                        <table style="width: 100% !important;" class="table table-sm table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th style="width:5%;" class="align-middle">No</th>
                                                <th class="align-middle">Product</th>
                                                <th class="align-middle">Karat</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($sale->saleDetails))
                                            @foreach($sale->saleDetails as $item)
                                                <tr>
                                                    <td class="align-middle">
                                                    {{ $loop->iteration }}
                                                    </td>  
                                                    <td class="align-middle">
                                                        <span class="font-semibold text-gray-600 text-md"> 
                                                        {{ $item->product_name }}
                                                        </span>
                                                        <br>
                                                        <span class="font-semibold text-green-600">
                                                            {{ $item->product_code }}
                                                        </span>
                                                        <div class="p-0 object-center">
                                                            <?php
                                                            
                                                                $image = $item->product->images;
                                                                $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                                            
                                                            ?>
                                                            <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
                                                                <img src="{{ $imagePath }}" order="0" width="70" class="img-thumbnail"/>
                                                            </a>
                                                            </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ @$item->product->karat?->label }}    
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="grid grid-cols-1 gap-2">

                                <div class="form-group">
                                    <?php
                                    $field_name = 'total';
                                    $field_lable = label_case('total');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $txt_total = format_currency($this->total); 
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <div class="flex-1">
                                        <input value="{{ $txt_total }}" type="text" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" disabled>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php
                                    $field_name = 'dp_nominal';
                                    $field_lable = label_case('dp_nominal');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    $txt_dp_nominal = format_currency($this->dp_nominal); 
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <div class="flex-1">
                                        <input value="{{ $txt_dp_nominal }}" type="text" id="{{ $field_name }}" class="form-control @error($field_name) is-invalid @enderror" disabled>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center mb-3">
                                    <span class="text-xl font-extrabold"> Sisa Pembayaran {{ $this->grand_total_text }}</span>
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
                                                        {{ $bank->kode_bank }} | {{ $bank->nama_bank }}
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

                            <div class="grid grid-cols-1 gap-2">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'note';
                                    $field_lable = label_case('note');
                                    $field_placeholder = $field_lable;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="font-medium" for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <div class="flex-1">
                                        <textarea name="{{$field_name}}" id="{{$field_name}}" rows="5" wire:model="note" class="form-control"></textarea>
                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </form>
            </div>
            <div class="modal-footer">
                <div class="float-right">
                    <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" wire:click.prevent="store">Tambah</button>
                </div>
            </div>


        </div>

    </div>
</div>

@push('page_scripts')
<script>
    
    function setAdditionalAttribute(name, selectElement) {
        let selectedText = selectElement.options[selectElement.selectedIndex].text;
        Livewire.emit('setAdditionalAttribute', name, selectedText);
    }
    
    document.addEventListener('livewire:load', function() {
        
        Livewire.on('reload-page-create', function() {
            window.location.reload();
            toastr.success('Item Berhasil di ditambahkan')
        });
    });



</script>
@endpush