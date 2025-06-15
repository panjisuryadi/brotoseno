        <div class="pt-3">


<table style="width: 100%;" class="table table-sm table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('no_buys_back') }}</th>
                            <th>{{ label_case('Tanggal') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('karat') }}</th>
                            <th>{{ label_case('berat') }}</th>

                            <th>{{ label_case('Status') }}</th>
                          
                        </tr>
                @php
                  $buysbacks = \Modules\BuysBack\Models\BuysBack::latest()->paginate(10, ['*'], 'buysbacks');
                @endphp
                        @forelse($buysbacks as $sale)
                           {{--  @if($loop->index > 3)
                               @break
                            @endif
 --}}

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td >{!!tgljam($sale->created_at) !!}</td>
                            <td>{{ $sale->no_buy_back }}</td>
                            <td>{{ $sale->cabang->name }}</td>
                            <td>{{ $sale->karat?->label }}</td>
                            <td>{{ $sale->weight }}</td>


                            <td>

                         <a href="{{ route('buysback.status', $sale->id) }}"
                            id="Status"
                            data-toggle="tooltip"
                             class="btn {{bpstts($sale->current_status?$sale->current_status->name:'PENDING')}} btn-sm uppercase">
                               {{$sale->current_status?$sale->current_status->name:'PENDING'}}
                            </a>

                            </td>
                          
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                 @if($buysbacks->links()->paginator->hasPages())
                    <tr>
                        <td colspan="8">
                            <div class="float-right">
                {{ $buysbacks->links('pagination.custom', ['paginator' => $buysbacks, 'paginationKey' => 'buysbacks']) }}
                            </div>
                        </td>  
                    </tr>
                    @endif 

                    </table>

      
                      

            </div>