<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit.prevent="generateReport">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Sales</label>
                                    <select wire:model.defer="sales_id" class="form-control" name="sales_id">
                                        <option value="">Select Sales</option>
                                        @foreach($dataSales as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Periode</label>
                                    <select wire:model="periode_type" class="form-control" name="periode_type">
                                        <option value="">Pilih Tipe Periode</option>
                                        <option value="month">Bulan</option>
                                        <option value="year">Tahun</option>
                                    </select>
                                </div>
                            </div>
                            @if($periode_type == 'month')
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Bulan <span class="text-danger">*</span></label>
                                    <input wire:model.defer="month" type="month" class="form-control" name="month">
                                    @error('month')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @elseif ($periode_type == 'year')
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tahun <span class="text-danger">*</span></label>
                                    <input wire:model.defer="year" type="number" min="1900" max="2099" step="1" class="form-control" name="year">
                                    @error('year')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Payments</label>
                                    <select wire:model.defer="payments" class="form-control" name="payments">
                                        <option value="">Select Payments</option>
                                        <option value="sales">Sales</option>
                                        <option value="sales_return">Sale Returns</option>
                                    </select>
                                </div>
                            </div>
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
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                @if($payments == 'sales')
                <div class="card-body">
                    <div class="my-3">
                        <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-700 md:text-3xl lg:text-4xl dark:text-white text-center" style="text-transform:uppercase;">LAPORAN PIUTANG {{ $payments }}</h1>
                    </div>
    
                    <p class="text-center mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Periode</p>
                    @livewire('reports.piutang.sales-report')
                @else
                    
                </div>
                @endif
            </div>
        </div>
    </div>