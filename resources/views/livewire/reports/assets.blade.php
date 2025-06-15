
<div class="col-12">
    <div class="flex relative py-2">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-b border-gray-300"></div>
        </div>
        
        <div class="relative flex justify-left">
            <span class="font-semibold tracking-widest pl-0 pr-3 text-sm uppercase text-dark">Laporan asset <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Laporan asset"></i>
            </span>
        </div>
    </div>

    {{-- <div class="card py-3 px-4 flex flex-row grid grid-cols-4 gap-2">
        <div class="form-group">
            <label>Start Date <span class="text-danger">*</span></label>
            <input wire:model.defer="start_date" type="date" class="form-control" name="start_date">
            @error('start_date')
            <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>End Date <span class="text-danger">*</span></label>
            <input wire:model.defer="end_date" type="date" class="form-control" name="end_date">
            @error('end_date')
            <span class="text-danger mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Status</label>
            <select wire:model.defer="purchase_return_status" class="form-control" name="purchase_return_status">
                <option value="">Select Status</option>
                <option value="Pending">Pending</option>
                <option value="Shipped">Shipped</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="w-full mt-4 btn btn-primary">
        
            <i class="bi bi-shuffle"></i>
            Filter Report
            </button>
        </div>
    </div> --}}

    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form wire:submit.prevent="generateReport">
                    <div class="form-row">
                        {{-- <div class="col-lg-4">
                            <div class="form-group">
                                <label>Tipe Periode</label>
                                <select wire:model="periode_type" class="form-control" name="periode_type">
                                    <option value="">Pilih Tipe Periode</option>
                                    <option value="month">Bulan</option>
                                    <option value="year">Tahun</option>
                                </select>
                            </div>
                        </div> --}}
                        {{-- @if($periode_type == 'month') --}}
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Bulan <span class="text-danger">*</span></label>
                                <input wire:model.defer="month" type="month" class="form-control" name="month">
                                @error('month')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- @elseif ($periode_type == 'year')
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Tahun <span class="text-danger">*</span></label>
                                <input wire:model.defer="year" type="number" min="1900" max="2099" step="1" class="form-control" name="year">
                                @error('year')
                                <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @endif --}}
                    </div>
                    {{-- <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select wire:model.defer="purchase_return_status" class="form-control" name="purchase_return_status">
                                    <option value="">Select Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">
                            <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                            Filter Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive mt-1">
                <div class="table-wrap">
                    <table class="table">
                        <thead class="bg-green-500 text-uppercase">
                            <tr>
                                <th>auto</th>
                                <th width="10%">auto</th>
                                <th width="20%">Input</th>
                                <th>Auto (berat x harga)</th>
                            
                            </tr>
                        </thead> 

                        <thead class="bg-gray-300 uppercase text-gray-800">
                            <tr>
                                <th>Asset</th>
                                <th>Berat</th>
                                <th >Harga (%)</th>
                                <th>24K</th>
                            
                            </tr>
                        </thead>

                        <tbody>
                        {{-- Stok office --}}
                            <tr >
                                <td><b>Stok Office</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            
                            </tr> 

                            @foreach ($stock_office as $key => $item)
                            <tr class="text-center">
                                <td>{{ $item->karat?->label }}</td>
                                <td>{{ formatBerat($item->berat_real) }} gr</td>
                                <td>
                                    <div class="form-group">
                                        <?php
                                            $field_name = 'stock_office_array.' . $item->karat_id . '.coef';
                                            $field_lable = __('Tentukan harga (%)');
                                            $field_placeholder = Label_case($field_lable);
                                            $required = '';
                                        ?>
                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:change="hitungHarga('office', {{$item->karat_id}})" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" >
                                    </div>
                                </td>
                                <td>{{ formatBerat($stock_office_array[$item->karat_id]['pure_gold'] ?? 0) }}</td>
                            </tr> 
                            @endforeach
                        {{-- Stok Lantakan --}}
                            <tr >
                                <td><b>Stok Lantakan</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            
                            </tr> 

                            @foreach ($stock_office_lantakan as $key => $item)
                                @php
                                @endphp
                                <tr class="text-center">
                                    <td>{{ $item->karat?->label }}</td>
                                    <td>{{ formatBerat($item->weight) }} gr</td>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                                $field_name = 'stock_office_lantakan_array.' . $item->karat_id . '.coef';
                                                $field_lable = __('Tentukan harga (%)');
                                                $field_placeholder = Label_case($field_lable);
                                                $required = '';
                                            ?>
                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:change="hitungHarga('office_lantakan', {{$item->karat_id}})" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" >
                                        </div>
                                    </td>
                                    <td>{{ formatBerat($stock_office_lantakan_array[$item->karat_id]['pure_gold'] ?? 0) }}</td>
                                </tr> 
                            @endforeach
                        {{-- Stok Rongsok --}}
                            <tr >
                                <td><b>Stok Rongsok</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr> 

                            @foreach ($stock_office_rongsok as $key => $item)
                                <tr class="text-center">
                                    <td>{{ $item->karat?->label }}</td>
                                    <td>{{ formatBerat($item->weight) }} gr</td>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                                $field_name = 'stock_office_rongsok_array.' . $item->karat_id . '.coef';
                                                $field_lable = __('Tentukan harga (%)');
                                                $field_placeholder = Label_case($field_lable);
                                                $required = '';
                                            ?>
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:change="hitungHarga('office_rongsok', {{$item->karat_id}})" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" >
                                        </div>
                                    </td>
                                    <td>{{ formatBerat($stock_office_rongsok_array[$item->karat_id]['pure_gold'] ?? 0) }}</td>
                                </tr> 
                            @endforeach

                        {{-- Stok Pending Office --}}
                            <tr >
                                <td><b>Stok Pending Office</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            
                            </tr> 

                            @foreach ($stock_office_pending as $key => $item)
                                <tr class="text-center">
                                    <td>{{ $item->karat?->label }}</td>
                                    <td>{{ formatBerat($item->berat_real) }} gr</td>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                                $field_name = 'stock_office_pending_array.' . $item->karat_id . '.coef';
                                                $field_lable = __('Tentukan harga (%)');
                                                $field_placeholder = Label_case($field_lable);
                                                $required = '';
                                            ?>
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:change="hitungHarga('office_pending', {{$item->karat_id}})" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" >
                                        </div>
                                    </td>
                                    <td>{{ formatBerat($stock_office_pending_array[$item->karat_id]['pure_gold'] ?? 0) }}</td>
                                </tr> 
                            @endforeach

                        {{-- Stok Ready Office --}}
                            <tr >
                                <td><b>Stok Ready Office</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            
                            </tr> 

                            @foreach ($stock_office_ready as $key => $item)
                                <tr class="text-center">
                                    <td>{{ $item->karat?->label }}</td>
                                    <td>{{ formatBerat($item->berat_real) }} gr</td>
                                    <td>
                                        <div class="form-group">
                                            <?php
                                                $field_name = 'stock_office_ready_array.' . $item->karat_id . '.coef';
                                                $field_lable = __('Tentukan harga (%)');
                                                $field_placeholder = Label_case($field_lable);
                                                $required = '';
                                            ?>
                                            <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:change="hitungHarga('office_ready', {{$item->karat_id}})" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" >
                                        </div>
                                    </td>
                                    <td>{{ formatBerat($stock_office_ready_array[$item->karat_id]['pure_gold'] ?? 0) }}</td>
                                </tr> 
                            @endforeach

                        {{-- Stok Cabang --}}
                            <tr >
                                <td><b>Stok Cabang</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr> 

                            @foreach ($stock_cabang_array as $key => $datas)
                                @foreach ($datas as $k => $collection)
                                    
                                    <tr>
                                        <td><b> {{ $key }} - {{ label_case($k) }}</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr> 
                                    @foreach ($collection as $item)
                                        <tr class="text-center">
                                            <td>{{ $item->karat?->label }}</td>
                                            <td>{{ formatBerat($item->berat_real) }} gr</td>
                                            <td>
                                                <div class="form-group">
                                                    <?php
                                                        $field_name = 'stock_cabang_coef.' .$key. '.' .$k. '.' . $item->karat_id;
                                                        $field_lable = __('Tentukan harga (%)');
                                                        $field_placeholder = Label_case($field_lable);
                                                        $required = '';
                                                        $params = [
                                                            'cabang' => $key,
                                                            'status' => $k,
                                                            'karat_id' => $item->karat_id,
                                                        ];
                                                    ?>
                                                <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:change="hitungHarga('cabang', {{ json_encode($params) }})" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}" >
                                                </div>
                                            </td>
                                            <td>{{ formatBerat($stock_cabang_24[$key][$k][$item->karat_id] ?? 0) }}</td>
                                        </tr> 
                                    @endforeach
                                @endforeach
                            @endforeach
                            
                        
                        </tbody>
                    </table>

                    <div class="mt-4 flex justify-between">
                        <div></div>
                        <div class="form-group">
                            {{-- <a class="px-5 btn btn-danger" href="{{ route("laporanasset.index") }}">
                                @lang('Cancel')</a> --}}
                            <button type="submit" class="px-5 btn btn-success" wire:click="submit()">@lang('Save') <i class="bi bi-check"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>