<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" wire:ignore.self>
    <div class="modal-xl modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-semibold text-lg" id="checkoutModalLabel">
                    <i class="bi bi-cart-check text-primary"></i>
                    Konfirmasi Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-0" style="max-height: 500px; overflow: scroll;">
                <form id="checkout-form" wire:submit.prevent="store">
                    @csrf
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div>
                                @if(!auth()->user()->isUserCabang())
                                <div class="form-group py-2">
                                    <select class="form-control @error('cabang_id') is-invalid @enderror" name="cabang_id" id="cabang_id" wire:model="cabang_id">
                                        <option value="" selected>Pilih Cabang</option>
                                        @foreach($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}">
                                            {{ $cabang->code }} | {{ $cabang->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cabang_id'))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first('cabang_id') }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="card shadow-md">
                                <div class="card-header">
                                    <h3 class="font-bold text-medium">
                                        Perhitungan Biaya
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="p-2 grid grid-cols-2 gap-4 my-2 mt-0">
                                        <div class="px-1">
                                            <div class="form-group mt-0">
                                                <label for="total_amount">Total <span class="text-danger">*</span></label>
                                                <input id="total_amount" type="text" class="form-control" name="total_amount" value="{{ $this->total_amount_text}}" disabled required>
                                            </div>
                                            <div class="form-group my-3">
                                                <div class="grid grid-cols-2 gap-2 justify-between mb-1">
                                                    <p>Tambahan Lainnya (Opsional)</p>
                                                    @if (count($other_fees) < 6) <a wire:click="add_other_fee" href="#" class="btn btn-sm btn-success w-1/5 place-self-end"><i class="bi bi-plus"></i></a>
                                                        @endif
                                                </div>
                                                @if (count($other_fees))
                                                <div class="grid grid-cols-7 gap-2 items-center">
                                                    @foreach ($other_fees as $index => $fee)
                                                    <div class="col-span-6 grid grid-cols-2 gap-2">
                                                        <div class="form-group">
                                                            <?php
                                                            $field_name = 'other_fees.' . $index . '.note';
                                                            ?>
                                                            <input type="text" class="form-control @error($field_name) is-invalid @enderror" wire:model.debounce.500ms="{{$field_name}}" placeholder="Catatan">
                                                            @if ($errors->has($field_name))
                                                            <span class="invalid feedback" role="alert">
                                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                            </span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                            $field_name = 'other_fees.' . $index . '.nominal';
                                                            ?>
                                                            <input type="number" class="form-control @error($field_name) is-invalid @enderror" wire:model.debounce.500ms="{{ $field_name }}" wire:change="calculateGrandTotal" placeholder="Nominal" min="0">
                                                            @if ($errors->has($field_name))
                                                            <span class="invalid feedback" role="alert">
                                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a wire:click="remove_other_fee({{$index}})" href="#" class="btn btn-sm btn-danger place-self-center align-self-start"><i class="bi bi-trash"></i></a>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="px-1">
                                            <div class="form-group">
                                                <?php
                                                $field_name = 'diskon';
                                                ?>
                                                <label for="discount">Diskon <span class="small text-danger">(Nominal)</span></label>
                                                <input id="discount" type="number" class="form-control @error($field_name) is-invalid @enderror" name="discount" wire:model.debounce.500ms="{{$field_name}}" min="0">
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="note">Grand Total</label> <span class="text-danger small" id="message"></span>
                                                <input id="final" type="text" class="form-control text-black text-3xl" name="final" value="{{ !empty($this->dp_payment) ? format_currency($this->tmp_grand_total) : $this->grand_total_text}}" disabled>
                                                @if ($errors->has('grand_total'))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first('grand_total') }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-md">
                                <div class="card-header">
                                    <h3 class="font-bold text-medium">
                                        Pembayaran DP
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="p-2 grid grid-cols-2 gap-4 my-2 mt-0">
                                        <div class="px-1">
                                            <div class="form-group my-3">
                                                <div class="grid grid-cols-7 gap-2 items-center">
                                                    <div class="col-span-6 grid grid-cols-2 gap-2">
                                                        <div class="form-group">
                                                            <?php
                                                            $field_name = 'dp_payment';
                                                            ?>
                                                            <label for="dp_payment"> Pembayaran DP ? </label> <span class="text-danger small" id="dp_payment"></span>
                                                            <input type="checkbox" class="form-control @error($field_name) is-invalid @enderror" wire:model.debounce.500ms="{{$field_name}}">
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
                                        @if($dp_payment)
                                        <div class="px-1">
                                            <div class="form-group">
                                                <?php
                                                $field_name = 'dp_nominal';
                                                ?>
                                                <label for="discount">Nominal DP <span class="small text-danger">(Nominal)</span></label>
                                                <input id="number" type="number" class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" wire:model.debounce.500ms="{{$field_name}}" min="0">
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="note">Sisa</label> <span class="text-danger small" id="message"></span>
                                                <input id="final" type="text" class="form-control text-black text-3xl" name="remain_amount" value="{{ format_currency($remain_amount )}}" disabled>
                                        </div>
                                        @endif
                                    </div>
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
                                                    <label>Grand Total</label> <span class="text-danger small" id="message"></span>
                                                    <input type="text" class="form-control text-black text-xl" value="{{ !empty($this->dp_nominal) ? format_currency($this->dp_nominal) : $this->grand_total_text}}" disabled>
                                                    @if ($errors->has('grand_total'))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first('grand_total') }}.</small class="text-danger">
                                                    </span>
                                                    @endif
                                                </div>
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
                            <div class="form-group mb-5">
                                <label for="note">Potongan
                                    <span class="small text-blue-500">(Jika diperlukan)</span>
                                </label>
                                <textarea name="note" id="note" rows="3" class="form-control" wire:model.debounce.500ms="note"></textarea>
                            </div>
                        </div>

                        <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            {{-- batas --}}
                            <div class="px-3 py-3 sm:p-6 border border-2 mt-3 mb-3 shadow rounded rounde-xl ">
                                <div class="flex flex-col items-start justify-between mb-6">
                                    <span class="text-sm font-medium text-gray-600">Nama</span>
                                    <span class="text-lg font-medium text-gray-800">
                                        {!! settings()->company_name !!}</span>
                                </div>
                                <div class="flex flex-col items-start justify-between mb-6">
                                    <span class="text-sm font-medium text-gray-600">No Rekening</span>
                                    <span class="text-lg font-medium text-gray-800">003003999333</span>
                                </div>

                                <div class="flex flex-row items-center justify-between">
                                    <div class="flex flex-col items-start">
                                        <span class="text-sm font-medium text-gray-600">Qty</span>
                                        <span class="text-lg font-medium text-gray-800">{{ Cart::instance($cart_instance)->count() }}</span>
                                    </div>

                                </div>
                            </div>
                            {{-- batas --}}
                        </div>
                        <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                            <div class="flex  flex-row justify-center">
                                <div class="justify-center items-center px-2 py-3 rounded-lg">
                                    <div class="justify-center text-center items-center">
                                        {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG('tess','QRCODE', 12, 12) !!}
                                    </div>
                                    <div class="py-2 justify-center text-center items-center font-semibold uppercase text-gray-600 no-underline text-lg hover:text-red-600 leading-tight">
                                        {{ $customer_id }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tunai" role="tabpanel" aria-labelledby="tunai-tab">
                            <ul class="flex flex-col bg-white p-1">
                                @foreach(\Modules\DataBank\Models\DataBank::get() as $row)
                                <li class="border-gray-200 flex flex-row mb-2">
                                    <div class="select-none cursor-pointer bg-gray-10 flex flex-1 items-center p-2  transition duration-500 ease-in-out transform hover:-translate-y-1 hover:shadow-lg border-top">
                                        <div class="flex flex-col rounded-md w-14 h-14 bg-white justify-center items-center mr-2">
                                            @if($row->kode_bank == '002')
                                            <img src="{{asset('images/icon/bri.png')}}">
                                            @elseif($row->kode_bank == '003')
                                            <img src="{{asset('images/icon/mandiri.png')}}">
                                            @else
                                            <img src="{{asset('images/icon/bri.png')}}">
                                            @endif
                                        </div>
                                        <div class="flex-1 pl-1 mr-16">
                                            <div class="text-gray-600 font-medium text-lg font-semibold">
                                                {{$row->nama_bank}}
                                            </div>
                                            <div class="text-gray-400 text-sm">
                                                {{$row->kode_bank}}
                                            </div>
                                        </div>
                                        <div class="text-gray-600 text-xs">{{$row->no_akun}}</div>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div> -->
                    </div>
                    <!-- <ul class="nav nav-tabs text-md py-0 justify-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-wallet"></i>&nbsp;TUNAI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="bi bi-cash-coin"></i>&nbsp;Transfer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="qr-tab" data-toggle="tab" href="#qr" role="tab" aria-controls="qr" aria-selected="false">
                                <i class="bi bi-upc-scan"></i>&nbsp;QR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link payment" id="tunai-tab" data-toggle="tab" href="#tunai" role="tab" aria-controls="tunai" aria-selected="false"><i class="bi bi bi-credit-card"></i>&nbsp;EDC</a>
                        </li>

                    </ul> -->
                </form>
            </div>
            <div class="modal-footer">
                <div class="flex justify-between">
                    <div></div>
                    <div>
                        <button type="button" class="px-2 btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button wire:click.prevent="store" class="px-5 btn bg-red-400 text-white">Simpan</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('page_css')
    <style type="text/css">
        label {
            display: inline-block;
            margin-bottom: 0.2rem;
        }

        .form-group {
            margin-bottom: 0.3rem;
        }
    </style>
    @endpush
    @push('page_scripts')

    @endpush