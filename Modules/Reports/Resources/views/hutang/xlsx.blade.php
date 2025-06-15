<table class="table table-bordered table-striped mb-0 text-sm">
    <thead>
        <tr>
            <th colspan="6">Laporan Hutang Pembelian</th>
        </tr>
        <tr>
            <th colspan="6">{{ $period }}</th>
        </tr>
        <tr>
            <th colspan="6">Tipe Pembayaran : {{ $payment_type }}</th>
        </tr>
        <tr>
            <th colspan="6">Supplier : {{ $supplier }}</th>
        </tr>
        <tr>
            <th colspan="6">Sisa Hutang : {{ $total_debt }} gr</th>
        </tr>
        <tr></tr>
        <tr>
            <th>Date</th>
            <th>Berat / Karat</th>
            <th>Supplier</th>
            <th>Tipe Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @forelse($gr as $item)
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
                $info = 'Jatuh Tempo';
                $pembayaran = tanggal(@$item->pembelian->jatuh_tempo);
                if(!empty(@$item->pembelian->lunas) && @$item->pembelian->lunas == 'lunas') {
                $info .=' (Lunas) ';
                }
                }else if ($item->pembelian->tipe_pembayaran == 'cicil')
                {
                $info = 'Cicilan';
                $pembayaran = @$item->pembelian->cicil .' kali';
                if(!empty(@$item->pembelian->lunas) && @$item->pembelian->lunas == 'lunas') {
                $pembayaran .=' (Lunas) ';
                }
                }
                else{
                $info = '';
                $pembayaran = 'Lunas';
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