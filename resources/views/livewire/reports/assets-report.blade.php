
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
                            @if(!empty($datas['office']))
                                @foreach ($datas['office'] as $item)
                                    @php
                                        $item = (object) $item;
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $item->karat?->label ?? 'a' }}</td>
                                        <td>{{ formatBerat($item->berat_real) }} gr</td>
                                        <td>{{ floatval($item->coef ?? 0) }} % </td>
                                        <td>{{ formatBerat($item->pure_gold ?? 0) }} gr</td>
                                    </tr> 
                                @endforeach
                            @else
                                <tr >
                                    <td class="text-center">Tidak ada data</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                        {{-- Stok Lantakan --}}
                            <tr >
                                <td><b>Stok Lantakan</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            
                            </tr>
                            @if(!empty($datas['office_lantakan']))
                                @foreach ($datas['office_lantakan'] as $key => $item)
                                    @php
                                        $item = (object) $item;
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $item->karat?->label }}</td>
                                        <td>{{ formatBerat($item->berat_real) }} gr</td>
                                        <td>{{ floatval($item->coef ?? 0) }} %</td>
                                        <td>{{ formatBerat($item->pure_gold ?? 0) }} gr</td>
                                    </tr> 
                                @endforeach
                            @else
                                <tr >
                                    <td class="text-center">Tidak ada data</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                        {{-- Stok Rongsok --}}
                            <tr >
                                <td><b>Stok Rongsok</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr> 
                            @if(!empty($datas['office_rongsok']))
                                @foreach ($datas['office_rongsok'] as $key => $item)
                                    @php
                                        $item = (object) $item;
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $item->karat?->label }}</td>
                                        <td>{{ formatBerat($item->weight) }} gr</td>
                                        <td>{{ floatval($item->coef ?? 0) }} %</td>
                                        <td>{{ formatBerat($item->pure_gold ?? 0) }} gr</td>
                                    </tr> 
                                @endforeach
                            @else
                            <tr >
                                <td class="text-center">Tidak ada data</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif

                        {{-- Stok Pending Office --}}
                            <tr >
                                <td><b>Stok Pending Office</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            
                            </tr> 
                            @if(!empty($datas['office_rongsok']))
                                @foreach ($datas['office_pending'] as $key => $item)
                                    @php
                                        $item = (object) $item;
                                    @endphp
                                
                                    <tr class="text-center">
                                        <td>{{ $item->karat?->label }}</td>
                                        <td>{{ formatBerat($item->berat_real) }} gr</td>
                                        <td>{{ floatval($item->coef ?? 0) }} %</td>
                                        <td>{{ formatBerat($item->pure_gold ?? 0) }} gr</td>
                                    </tr> 
                                @endforeach
                            @else
                            <tr >
                                <td class="text-center">Tidak ada data</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif

                        {{-- Stok Ready Office --}}
                            <tr >
                                <td><b>Stok Ready Office</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            
                            </tr> 
                            @if(!empty($datas['office_rongsok']))
                                @foreach ($datas['office_ready'] as $key => $item)
                                    @php
                                        $item = (object) $item;
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $item->karat?->label }}</td>
                                        <td>{{ formatBerat($item->berat_real) }} gr</td>
                                        <td>{{ floatval($item->coef ?? 0) }} %</td>
                                        <td>{{ formatBerat($item->pure_gold ?? 0) }} gr</td>
                                    </tr> 
                                @endforeach
                            @else
                                <tr >
                                    <td class="text-center">Tidak ada data</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif

                        {{-- Stok Cabang --}}
                            <tr >
                                <td><b>Stok Cabang</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr> 

                            @if(!empty($datas['office_rongsok']))
                                @foreach ($datas['cabang'] as $key => $datas)
                                    @foreach ($datas as $k => $collection)
                                        
                                        <tr>
                                            <td><b> {{ $key }} - {{ label_case($k) }}</b></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> 
                                        @foreach ($collection as $item)
                                            @php
                                                $item = (object) $item;
                                            @endphp
                                            <tr class="text-center">
                                                <td>{{ $item->karat->label ?? '-' }}</td>
                                                <td>{{ formatBerat($item->berat_real) }} gr</td>
                                                <td>{{ floatval($item->coef ?? 0) }} %</td>
                                                <td>{{ formatBerat($item->pure_gold ?? 0) }} gr</td>
                                            </tr> 
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @else
                                <tr >
                                    <td class="text-center">Tidak ada data</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>
                    
                    <div class="mt-4 flex justify-between">
                        <div></div>
                        @if ($this->is_report)
                            <div class="form-group">
                                {{-- <a class="px-5 btn btn-danger" href="{{ route("laporanasset.index") }}">
                                    @lang('Cancel')</a> --}}
                                {{-- <button type="button" id="reset-report" class="px-5 btn btn-danger" wire:click="delete()">@lang('Reset Report untuk bulan ini?') <i class="bi bi-check"></i></button> --}}
                                <button type="button" id="reset-report" class="px-5 btn btn-danger"><i class="bi bi-trash"></i> @lang('Reset Report untuk bulan ini?') </button>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
