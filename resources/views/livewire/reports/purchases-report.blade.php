<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit.prevent="generateReport">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input wire:model="start_date" type="date" class="form-control" name="start_date">
                                    @error('start_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <input wire:model="end_date" type="date" class="form-control" name="end_date">
                                    @error('end_date')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select wire:model="supplier_id" class="form-control" name="supplier_id">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-row gap-3">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    <span wire:target="generateReport" wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <i wire:target="generateReport" wire:loading.remove class="bi bi-shuffle"></i>
                                    Filter Report
                                </button>
                            </div>
                            <div class="form-group mb-0">
                                <a href="#" wire:click.prevent="resetFilter" class="btn btn-warning">
                                    <i class="bi bi-arrow-repeat"></i>
                                    Reset Filter
                                </a>
                            </div>
                            <div class="form-group mb-0">
                                <a href="#" wire:click.prevent="pdf" class="btn btn-success">
                                    <i class="bi bi-save"></i>
                                    PDF
                                </a>
                            </div>
                            <div class="form-group mb-0">
                                <a href="#" wire:click.prevent="export('xlsx')" class="btn btn-success">
                                    <i class="bi bi-save"></i>
                                    Excel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                  

<div class="flex flex-row grid grid-cols-3 gap-3 mb-2">
    

              <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
                            <i class="bi bi-receipt font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-primary">
                            {{ format_currency($total_harga) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold">
                            @lang('Purchases')
                         </div>
                        </div>
                    </div>
                </div>


      <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
                            <i class="bi bi-bar-chart font-2xl"></i>

                        </div>
                        <div>
                            <div class="text-value text-primary">
                           {{ formatBerat($total_emas) }} <small>gr</small>
                          </div>
                            <div class="text-muted text-uppercase font-weight-bold">
                               @lang('Gold')
                                </div>
                        </div>
                    </div>
                </div>



      <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
                         
                            <i class="bi bi-currency-dollar font-2xl"></i>
                        </div>
                        <div>
                            <div class="text-value text-primary">
                             {{ format_currency($total_harga) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold">
                           Pembelian <small class="text-muted">Dollar</small> </div>
                        </div>
                    </div>
                </div>







</div>



                    <table class="table table-bordered table-striped text-center mb-0">
                        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <thead>
                        <tr class="text-sm">
                            <th>@lang('Transaction Date')</th>
                            <th>@lang('Transaction No')</th>
                            <th>@lang('Supplier')</th>
                            <th>@lang('Detail')</th>
                            <th>@lang('Total')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($datas as $data)
                            <tr class="text-sm">
                                <td>{{ \Carbon\Carbon::parse($data->date)->format('d M, Y') }}</td>
                                <td>{{ $data->code }}</td>
                                <td>{{ $data->supplier_name }}</td>
                                <td  class="text-left">
                                    <div class="text-xs">
                                        <b>No. Surat Jalan / Invoice</b> : {{ $data->no_invoice }}
                                    </div>

                                    <div class="text-xs">
                                        @php
                                            $tgl_bayar = !empty($data->tgl_bayar) ?  $data->tgl_bayar : $data->date;
                                        @endphp
                                        <b>Tgl Bayar {{ !empty($data->nomor_cicilan) && $data->tipe_pembayaran == 'cicil'  ? '( Cicilan ke -' . $data->nomor_cicilan . ')' : ''  }}</b> : {{ \Carbon\Carbon::parse($tgl_bayar)->format('d M, Y H:i:s') }} {{-- tgl pembayarn diambil dari updated at untuk akomodir semua case pembayaran, ketika cicilan, jatuh tempo, dan lunas maka dia akan update ke table tipe pembelian--}}
                                    </div>
                                    {{-- <div class="text-xs">
                                        <b>Karat </b>: {{ $data->goodsreceiptitem->pluck('karat.label')->implode(', ')  }}
                                    </div> --}}
                                    @if($data->tipe_pembayaran != 'lunas')
                                    <div class="text-xs">
                                        <b>Tipe Pembayaran </b>: {{ label_case($data->tipe_pembayaran)  }}
                                    </div>
                                    @endif
                                    <div class="text-xs">
                                        <b>Status Pembayaran </b>: {{ !empty($data->lunas) ? label_case($data->lunas) : ($data->tipe_pembayaran =='lunas' ? 'Lunas' : 'Belum Lunas' )  }}
                                    </div>
                                    @if(!empty($data->total_emas) && empty($data->total_karat))
                                    <div class="text-xs">
                                        <b>Berat yang dibayar</b> : {{ floatval(!empty($data->jumlah_cicilan) ? $data->jumlah_cicilan :$data->total_emas)}} gr
                                    </div>
                                    @elseif(empty($data->total_emas) && !empty($data->total_karat))
                                    <div class="text-xs">
                                        <b>Karat yang dibayar</b> : {{ $data->total_karat }} ct
                                    </div>
                                    @else
                                    <div class="text-xs">
                                        <b>Berat yang dibayar</b> : {{ floatval(!empty($data->jumlah_cicilan) ? $data->jumlah_cicilan :$data->total_emas) }} gr
                                    </div>
                                    <div class="text-xs">
                                        <b>Karat yang dibayar</b> : {{ $data->total_karat }} ct
                                    </div>

                                    @endif
                                    
                                </td>
                                <td>
                                    @php
                                        $nominal = number_format(!empty( $data->nominal) ? $data->nominal : $data->harga_beli);
                                        
                                    @endphp
                                    {{ !empty($nominal) ? 'Rp. ' . $nominal : formatBerat($data->jumlah_cicilan) . ' gr' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <span class="text-danger">No Purchases Data Available!</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div @class(['mt-3' => $datas->hasPages()])>
                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
