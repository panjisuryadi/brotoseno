         <div class="pt-3">

                   <table style="width: 100%;" class="table table-sm table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('Karat') }}</th>
                            <th>{{ label_case('cabang') }}</th>
                            <th>{{ label_case('Berat') }}</th>
                            <th class="text-center">{{ label_case('Aksi') }}</th>
                        </tr>
                      @php

                  $StockPending = \Modules\Stok\Models\StockPending::latest()->paginate(10, ['*'], 'stockpending');
              
                   @endphp

                    @forelse($StockPending as $row)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->karat?->label }}</td>
                            <td>{{ $row->cabang->name }}</td>
                            <td>{{ $row->weight ?? ' - ' }}</td>
                            <td class="text-center">

                                    <a href="{{ route("stok.pending") }}"
                                     class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-eye"></i>&nbsp;@lang('Detail Stok Pending')
                                    </a>
                                @can('show_sales')
                                @endcan


                            </td>
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                  @if($StockPending->links()->paginator->hasPages())
                    <tr>
                        <td colspan="8">
                            <div class="float-right">
                  {{ $StockPending->links('pagination.custom', ['paginator' => $stockpending, 'paginationKey' => 'stockpending']) }}
                            </div>
                        </td>  
                    </tr>
                    @endif 


                    </table>
                   

            </div>