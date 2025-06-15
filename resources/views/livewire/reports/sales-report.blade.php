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
                        <!-- <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select wire:model.defer="sale_status" class="form-control" name="sale_status">
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Shipped">Shipped</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select wire:model.defer="payment_status" class="form-control" name="payment_status">
                                        <option value="">Select Payment Status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                        <option value="Partial">Partial</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        @if (!auth()->user()->isUserCabang())
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Cabang</label>
                                    <select wire:model="selected_cabang" class="form-control" name="selected_cabang">
                                        <option value="">Pilih Cabang</option>
                                        @foreach ($cabangs as $cabang)
                                            <option value="{{ $cabang->id }}">{{ $cabang->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selected_cabang')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif
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
                        <h2 class="text-xl uppercase font-bold mb-2">Laporan Penjualan</h2>
                        <h3 class="text-base font-semibold">{{ $this->period_text }}</h3>
                    </div>
                    <div>
                        @php
                            $target_cabang = $cabangs->first(function($item){
                                return $item->id == $this->selected_cabang;
                            });
                        @endphp
                        <p class="font-semibold">Cabang : {{ !empty($target_cabang)?ucwords($target_cabang->name):'-' }}</p>
                        <p class="font-semibold">Total Nominal : {{ format_uang($total_nominal) }}</p>
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
                    <table class="table table-bordered table-striped mb-0 text-xs">
                        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Cabang</th>
                            <th>Customer</th>
                            <th>Informasi Produk</th>
                            <!-- <th>Status</th> -->
                            <th>Total</th>
                            <!-- <th>Payment Status</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>
                                    <p class="font-bold">{{ $sale->reference }}</p>
                                    <p>{{ tanggal($sale->date) }}</p>
                                </td>
                                <td>{{ $sale->cabang->name }}</td>
                                <td>{{ $sale->customer_name }}</td>
                                <td>
                                    @php
                                        $output = collect($sale->saleDetails)->map(function ($detail, $index) {
                                            return "<p> - Produk " . ($index + 1) . " : {$detail->product->category?->category_name} / {$detail->product?->product_code} / {$detail->product->karat?->label} ({$detail->product->berat_emas} gr) <br> {$detail->product->berlian_short_label} </p>";
                                        })->implode('');
                                    @endphp
                                    <p>Jumlah : {{ $sale->saleDetails->count() }} buah</p>
                                    <p>Detail : {!! $output !!}</p>
                                </td>
                                <!-- <td>
                                    @if ($sale->status == 'Pending')
                                        <span class="badge badge-info">
                                    {{ $sale->status }}
                                </span>
                                    @elseif ($sale->status == 'Shipped')
                                        <span class="badge badge-primary">
                                    {{ $sale->status }}
                                </span>
                                    @else
                                        <span class="badge badge-success">
                                    {{ $sale->status }}
                                </span>
                                    @endif
                                </td> -->
                                <td>{{ format_uang($sale->grand_total_amount) }}</td>
                                <!-- <td>
                                    @if ($sale->payment_status == 'Partial')
                                        <span class="badge badge-warning">
                                    {{ $sale->payment_status }}
                                </span>
                                    @elseif ($sale->payment_status == 'Paid')
                                        <span class="badge badge-success">
                                    {{ $sale->payment_status }}
                                </span>
                                    @else
                                        <span class="badge badge-danger">
                                    {{ $sale->payment_status }}
                                </span>
                                    @endif

                                </td> -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <span class="text-danger">No Sales Data Available!</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    
                    <div @class(['mt-3' => $sales->hasPages()])>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
