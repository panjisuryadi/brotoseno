<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Periode</label>
                                    <select wire:model="period_type" class="form-control" name="period_type">
                                        <option value="">Pilih Tipe Periode</option>
                                        <option value="month">Bulan</option>
                                        <option value="year">Tahun</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                    @error('period_type')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @if ($period_type === 'month')
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Bulan <span class="text-danger">*</span></label>
                                        <input wire:model="month" type="month" class="form-control" name="month">
                                        @error('month')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @elseif ($period_type === 'year')
                                @php
                                    $currentYear = date('Y');
                                    $yearsRange = range($currentYear, $currentYear - 20);
                                @endphp
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <select wire:model="year" class="form-control" name="year">
                                            <option value="">Pilih Tahun</option>
                                            @foreach ($yearsRange as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                        @error('year')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @elseif ($period_type === 'custom')
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Tanggal Mula <span class="text-danger">*</span></label>
                                        <input wire:model="start_date" type="date" class="form-control" name="start_date" wire:change="resetEndDate">
                                        @error('start_date')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Tanggal Akhir <span class="text-danger">*</span></label>
                                        <input wire:model="end_date" type="date" class="form-control" name="end_date" min="{{ $this->getMinDate()}}">
                                        @error('end_date')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Pembayaran</label>
                                    <select wire:model="payment_type" class="form-control" name="payment_type">
                                        <option value="">Pilih Tipe Pembayaran</option>
                                        <option value="cicil">Cicilan</option>
                                        <option value="jatuh_tempo">Jatuh Tempo</option>
                                    </select>
                                    @error('payment_type')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select wire:model="supplier" class="form-control" name="supplier">
                                        <option value="">Semua Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row gap-3">
                            <div class="form-group mb-0">
                                <button wire:click.prevent="resetFilter" class="btn btn-primary">
                                    <span wire:target="resetFilter" wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <i wire:target="resetFilter" wire:loading.remove class="bi bi-shuffle"></i>
                                    Reset Filter
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header p-4">
                    <div class="text-center">
                        <h2 class="text-xl uppercase font-bold mb-2">Laporan Hutang Pembelian</h2>
                        <h3 class="text-base font-semibold">{{ $this->period_text }}</h3>
                    </div>
                    <div>
                        <p class="font-semibold">Tipe Pembayaran : {{ !empty($payment_type)?ucwords($payment_type):'-' }}</p>
                        @php
                            $target_supplier = $suppliers->first(function($item){
                                return $item->id == $this->supplier;
                            });
                        @endphp
                        <p class="font-semibold">Supplier : {{ !empty($target_supplier)?ucwords($target_supplier->supplier_name):'-' }}</p>
                        <p class="font-semibold">Sisa Hutang : {{ $debts }} gr</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row gap-3 float-right mb-3">
                        <div class="form-group mb-0">
                            <a href="#" wire:click.prevent="pdf" class="btn btn-outline-success">
                                <i class="bi bi-save"></i>
                                PDF
                            </a>
                        </div>
                        <div class="form-group mb-0">
                            <a href="#" wire:click.prevent="export('xlsx')" class="btn btn-outline-success">
                                <i class="bi bi-save"></i>
                                Excel
                            </a>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped mb-0 text-sm">
                        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Berat / Karat</th>
                            <th>Supplier</th>
                            <th>Tipe Pembayaran</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($goodsreceipt as $item)
                            <tr>
                                <td>
                                    <p class="font-bold">{{ $item->code }}</p>
                                    <p>{{ tanggal($item->date) }}</p>
                                </td>
                                <td>
                                    <p>
                                     Karat : <span class="font-bold">{{ $item->goodsreceiptitem->pluck('karat.label')->implode(', ') }}</span>
                                    </p>
                                    <p>
                                     Total Berat Kotor : <span class="font-bold">{{ $item->total_berat_kotor }} gr</span>
                                    </p>
                                    <p>
                                     Total Berat Emas : <span class="font-bold">{{ $item->total_emas }} gr</span>
                                    </p>
                                    <p>
                                     @php
                                         $sisa_hutang = $item->total_emas - $item->pembelian->detailCicilan->sum('jumlah_cicilan');
                                     @endphp
                                     Sisa Hutang : <span class="font-bold">{{ $sisa_hutang }} gr</span>
                                    </p>
                                </td>
                                <td>
                                    <p>{{ $item->supplier->supplier_name }}</p>
                                </td>
                                <td>
                                    @php
                                    if ($item->pembelian->tipe_pembayaran == 'jatuh_tempo') 
                                    {
                                        $info =  'Jatuh Tempo';
                                        $pembayaran =  tanggal(@$item->pembelian->jatuh_tempo);
                                        if(!empty(@$item->pembelian->lunas) && @$item->pembelian->lunas == 'lunas') {
                                            $info .=' (Lunas) ';
                                        }
                                    }else if ($item->pembelian->tipe_pembayaran == 'cicil') 
                                    {
                                        $info =  'Cicilan';
                                        $pembayaran =  @$item->pembelian->cicil .' kali';
                                        if(!empty(@$item->pembelian->lunas) && @$item->pembelian->lunas == 'lunas') {
                                            $pembayaran .=' (Lunas) ';
                                        }
                                    }
                                    else{
                                        $info =  '';
                                        $pembayaran =  'Lunas';
                                    }
                                    @endphp
                                    <div class="items-left text-left">
                                        <p class="small text-gray-800">{{ $info }}</p>
                                        <p class="text-gray-800">{{$pembayaran}}</p>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="4">
                                    <span class="text-danger">No Data Available!</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div @class(['mt-3' => $goodsreceipt->hasPages()])>
                        {{ $goodsreceipt->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
