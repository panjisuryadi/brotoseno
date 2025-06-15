

<div class="card">
    <div class="flex flex-row grid grid-cols-1 gap-2 px-4 py-3">

        <div class="form-row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Data Sales</label>
                    <select wire:model="sales_id" name="sales_id" class="form-control">
                        <option value="">Pilih Sales</option>
                        @foreach ($listSales as $row)
                        <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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

    <div class="p-5 border">
        <div class="text-center">
            <div style="font-size:20px;">
                <div class="font-semibold tracking-wide">Rekapan Transaksi Sales</div>
            </div>
            <div>
                Periode <span id="periods">2023</span>
            </div>
        </div>

        @php
            $name = '-';
            if(!empty($sales_id) ) {
                $name = $this->salesArray[$this->sales_id]['name'];
            }
        @endphp
        <div class="pt-3 table-responsive">
            <div class="pb-3">
                <table width="100%">
                    <tbody><tr>
                        <td width="50%">
                            <table>
                                <tbody>
                                <tr>
                                    <td width="10%"><b>Nama Sales</b></td>
                                    <td width="10%" colspan="2">: <span class="names" id="names">{{ $name }}</span></td>
                                </tr>
                                <tr>
                                    <td><b>Total Piutang Emas</b></td>
                                    <td width="10%">: <span class="piutangemas" id="piutangemas">{{ formatBerat($piutang_emas) }} gr</span> </td>
                                    <td width="2%"><b>Dibayar</b></td>
                                    <td width="10%">: <span class="emasdibayar" id="emasdibayar">{{ formatBerat($dibayar_emas) }} gr</span></td>
                                    <td width="2%"><b>Sisa</b> </td>
                                    <td width="10%">: <span class="sisapiutangemas" id="sisapiutangemas">{{ formatBerat($piutang_emas-$dibayar_emas) }} gr</span> </td>
                                    <td width="35%"></td>
                                </tr>
                                <tr>
                                    <td><b>Total Piutang Nominal</b></td>
                                    <td>: <span class="piutangnominal" id="piutangnominal"> Rp. {{ rupiah($piutang_nominal) }}</span> </td>
                                    <td> <b>Dibayar</b></td>
                                    <td>: <span class="nominaldibayar" id="nominaldibayar">Rp. {{ rupiah($dibayar_nominal) }}</span></td>
                                    <td><b>Sisa</b> </td>
                                    <td>: <span class="sisapiutangnominal" id="sisapiutangnominal">Rp. {{ rupiah($piutang_nominal - $dibayar_nominal) }}</span> </td>
                                    <td></td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <h1 class="font-semibold">Rekapan Transaksi Emas</h1>
            <table class="table table-bordered mt-2" id="tablejournalemas">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Piutang JSR</th>
                        <th>Bayar</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $saldo = 0;
                    @endphp
                    @forelse ($rekapan_emas as $item)
                        @php 
                            $saldo += ($item->total_jumlah - $item->jumlah_cicilan);
                            $keterangan = 'Setoran';
                            if($item->tipe_emas != 'setoran' && !empty($item->berat)){
                                if($item->tipe_emas == 'tipe_nominal'){
                                    $keterangan = 'Bayar dengan nominal Rp. ' . rupiah($item->nominal);
                                }else if($item->tipe_emas == 'lantakan'){
                                    $keterangan = 'Bayar dengan ' .label_case($item->tipe_emas) . ' ' . formatBerat($item->jumlah_cicilan) . ' gr';
                                }else{
                                    $keterangan = 'Bayar dengan ' .label_case($item->tipe_emas) . ' ' . ($item->tipe_emas == 'rongsok' ? $item->karat_name . ' ' : '') . formatBerat($item->berat) . ' gr';
                                }

                            }
                        @endphp
                        <tr>
                            <td>{{ tanggal($item->tgl_transaksi, true, true) }} </td>
                            <td>{{ $item->invoice_no }}</td>
                            <td>{{ $item->customer_name . ' / ' . $item->market }}</td>
                            <td> {{ $keterangan }} </td>
                            <td> {{ formatBerat($item->total_jumlah) }} gr</td>
                            <td> {{ formatBerat($item->jumlah_cicilan) }} gr</td>
                            <td> {{ formatBerat($saldo) }} gr </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-3 table-responsive">
            <h1 class="font-semibold">Rekapan Transaksi Nominal</h1>
            <table class="table table-bordered mt-2" id="tablejournalnominal">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Piutang JSR</th>
                        <th>Bayar</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $saldo = 0;
                    @endphp
                    @forelse ($rekapan_nominal as $item)
                        @php 
                            $saldo += ($item->total_nominal - $item->nominal);
                            $keterangan = '';
                            $keterangan = 'Setoran';
                            if($item->tipe_emas != 'setoran' && !empty($item->berat)){
                                if($item->tipe_emas == 'tipe_nominal'){
                                    $keterangan = 'Bayar dengan nominal Rp. ' . rupiah($item->nominal);
                                }else if($item->tipe_emas == 'lantakan'){
                                    $keterangan = 'Bayar dengan ' .label_case($item->tipe_emas) . ' ' . formatBerat($item->jumlah_cicilan) . ' gr';
                                }else{
                                    $keterangan = 'Bayar dengan ' .label_case($item->tipe_emas) . ' ' . ($item->tipe_emas == 'rongsok' ? $item->karat_name . ' ' : '') . formatBerat($item->berat) . ' gr';
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ tanggal($item->tgl_transaksi, true, true) }} </td>
                            <td>{{ $item->invoice_no }}</td>
                            <td>{{ $item->customer_name . ' / ' . $item->market }}</td>
                            <td> {{ $keterangan }} </td>
                            <td>Rp. {{ rupiah($item->total_nominal) }}</td>
                            <td>Rp. {{ rupiah($item->nominal) }}</td>
                            <td>Rp. {{ rupiah($saldo) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

