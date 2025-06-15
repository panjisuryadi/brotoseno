    <div class="pt-3">

                   <table style="width: 100%;" class="table table-sm table-striped table-bordered">
                        <tr>
                            <th style="width:2%;" class="text-center">{{ label_case('No') }}</th>
                            <th style="width:5%;" class="text-center">{{ label_case('Invoice') }}</th>
                            <th style="width:6%;" class="text-center">{{ label_case('Cabang') }}</th>
                            <th style="width:11%;" class="text-center">{{ label_case('Customer') }}</th>
                            <th style="width:6%;" class="text-center">{{ label_case('total') }}</th>
                            <th class="text-center" style="width:28%;">{{ label_case('Aksi') }}</th>
                        </tr>

                       @php
            $penjualan = \Modules\Sale\Entities\Sale::akses()->latest()->paginate(10, ['*'], 'penjualan');
            @endphp   
                    @forelse($penjualan as $row)
                           
                                {{-- {{ $row }} --}}

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $row->reference }}</td>
                            <td class="text-center">{{ @$row->cabang->name }}</td>
                            <td class="text-center">
                                {{ @$row->customer->customer_name }}</td>
                            <td class="text-center font-semibold"><small>Rp .</small>{{ rupiah($row->total_amount) }}</td>
                            <td class="text-center">
                                
                     
                  <a target="_blank" class="btn btn-sm btn-success mfe-1 d-print-none" href="{{ route('sales.show', $row->id) }}">
                            <i class="bi bi-eye"></i> Show
                        </a>   

                         <a target="_blank" class="btn btn-sm btn-warning mfe-1 d-print-none" href="{{ route('sales.invoice', $row->id) }}">
                            <i class="bi bi-save"></i> Cetak Nota
                        </a>   

                        <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route('sales.pdf', $row->id) }}">
                            <i class="bi bi-save"></i> Print PDF
                        </a>


                                @can('show_sales')
                                @endcan


                            </td>
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                        @if($penjualan->links()->paginator->hasPages())
                        <tr>
                            <td colspan="8">
                                <div class="float-right">
                            {{ $penjualan->links('pagination.custom', ['paginator' => $penjualan, 'paginationKey' => 'penjualan']) }}
                                </div>
                            </td>  
                        </tr>
                    @endif 
                    </table>
         
            </div>