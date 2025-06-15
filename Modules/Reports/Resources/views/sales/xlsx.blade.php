<table class="table table-bordered table-striped mb-0 text-sm">
    <thead>
        <tr>
            <th colspan="6">Laporan Penjualan</th>
        </tr>
        <tr>
            <th colspan="6">{{ $period }}</th>
        </tr>
        <tr>
            <th colspan="6">Total Nominal : {{ format_uang($total_nominal) }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>Invoice</th>
            <th>Cabang</th>
            <th>Customer</th>
            <th>Informasi Produk</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sales as $sale)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>
                <p class="font-bold">{{ $sale->reference }}</p>
                <p>{{ tanggal($sale->date) }}</p>
            </td>
            <td>{{ $sale->cabang->name }}</td>
            <td>{{ $sale->customer_name }}</td>
            <td>
                Jumlah : {{ $sale->saleDetails->count() }} buah
                <ul>
                    @foreach($sale->saleDetails as $index => $detail)
                        <li>
                            Produk {{ $index + 1 }}:
                            {{ $detail->product->category->category_name }} /
                            {{ $detail->product->product_code }} /
                            {{ $detail->product->karat?->label }} ({{ $detail->product->berat_emas }} gr)
                            {{ $detail->product->berlian_short_label }}
                        </li>
                    @endforeach
                </ul>
            </td>
            <td>{{ format_uang($sale->total_amount) }}</td>
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
