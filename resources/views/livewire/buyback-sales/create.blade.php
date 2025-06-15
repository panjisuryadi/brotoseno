<form wire:submit.prevent="store">
    @csrf
    <div class="row">

        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">

                    <div class="flex relative py-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Buy Back Sales')}} &nbsp;<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Buys Back Sale')}}"></i>
                            </span>
                        </div>
                    </div>


                    <div class="flex flex-row grid grid-cols-3 gap-2">

                        <div class="form-group">
                            <?php
                            $field_name = 'buyback_sales.no_buy_back';
                            $field_lable = __('invoice');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            ?>
                            <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                            <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{$field_name}}" readonly>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <?php
                            $field_name = 'buyback_sales.date';
                            $field_lable = __('Tanggal');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = 'required';
                            ?>
                            <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                            <input type="date" class="form-control {{ $invalid }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>

                    </div>


                    <div class="flex flex-row grid grid-cols-3 gap-2">
                        <div class="form-group">
                            <?php
                            $field_name = 'buyback_sales.customer_sales_id';
                            $field_lable = __('customer sales');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
                            <label for="{{ $field_name }}" style="margin-bottom: 0.2rem;">Customer Sales <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control select2 {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                    <option value="" selected>Pilih Customer Sales</option>
                                    @foreach($customerSales as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div>
                                <?php
                                $field_name = 'buyback_sales.sales_id';
                                $field_lable = __('sales');
                                $field_placeholder = Label_case($field_lable);
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = '';
                                ?>
                                <label for="{{ $field_name }}" style="margin-bottom: 0.2rem;">Sales <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-control select2 {{ $invalid }}" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                        <option value="" selected>Pilih Sales</option>
                                        @foreach($dataSales as $sales)
                                        <option value="{{ $sales->id }}">{{ $sales->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>


                    <div class="flex flex-row grid grid-cols-3 gap-2">

                        <div class="form-group">
                            <?php
                            $field_name = 'buyback_sales.product_name';
                            $field_lable = label_case('nama produk');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                            <input wire:model="{{ $field_name }}" class="form-control {{ $invalid }}" type="text" name="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <?php
                            $field_name = 'buyback_sales.karat_id';
                            $field_lable = label_case('karat');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                            <select class="form-control select2 {{$invalid}}" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                <option value="" selected>Pilih Karat</option>
                                @foreach($karats as $karat)
                                <option value="{{ $karat->id }}">{{ $karat->label }}</option>
                                @if (count($karat->children))
                                    @foreach ($karat->children as $kategori )
                                    <option value="{{ $kategori->id }}">{{ $kategori->label }}</option>
                                    @endforeach
                                @endif
                                @endforeach
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <?php
                            $field_name = 'buyback_sales.weight';
                            $field_lable = label_case('berat');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                            <input wire:model="{{ $field_name }}" class="form-control {{$invalid}}" type="number" name="{{ $field_name }}" min="0" step="0.001" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>



                    </div>


                    <div class="grid grid-cols-2">
                        <div class="form-group">
                            <?php
                            $field_name = 'buyback_sales.nominal';
                            $field_lable = label_case('nominal');
                            $field_placeholder = $field_lable;
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = "required";
                            ?>
                            <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                            <input wire:model="{{ $field_name }}" class="form-control {{ $invalid }}" type="number" name="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}">
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                        <div class="flex justify-center items-center">
                            <span class="text-2xl font-extrabold">{{ $this->nominal_text }}</span>
                        </div>
                    </div>







                    <div class="form-group">
                        <?php
                        $field_name = 'buyback_sales.note';
                        $field_lable = __('Keterangan');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = '';
                        ?>
                        <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                        <textarea wire:model="{{ $field_name }}" name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" rows="5" id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}"></textarea>
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>



                    <div class="flex justify-between">
                        <div></div>
                        <div class="form-group">
                            <a class="px-5 btn btn-danger" href="{{ route("buysback.index") }}">
                                @lang('Cancel')</a>
                            <button type="submit" class="px-5 btn btn-success">@lang('Create') <i class="bi bi-check"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>