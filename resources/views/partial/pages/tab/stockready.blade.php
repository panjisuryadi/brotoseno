    <div class="pt-3">

                   <table style="width: 100%;" class="table table-sm table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th class="text-center">{{ label_case('Date') }}</th>
                            <th>{{ label_case('Produk') }}</th>
                            <th>{{ label_case('Code') }}</th>
                            <th>{{ label_case('Karat') }}</th>
                            <th>{{ label_case('Status') }}</th>

                        </tr>

              @php
               $stockreadys = \Modules\Product\Entities\Product::ready()
               ->latest()
               ->paginate(10, ['*'], 'stockready');
              @endphp   
                    @forelse($stockreadys as $row)
                       {{--  @if($loop->index > 4)
                             @break
                         @endif --}}
                           {{-- {{ $row }} --}}

                           <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{!!tgljam($row->created_at) !!}</td>
                                <td>{{ @$row->product_name }}</td>
                                <td>
                                    <span class="text-center text-jsr font-semibold">
                                    {{ @$row->product_code }}
                                    </span>
                                </td>
                                <td>{{ @$row->karat?->label }}</td>
                                <td>
                                    <span class="bg-green-500 px-2 py-1 text-xs text-center text-white uppercase rounded-md">  
                                        {{ @$row->product_status->name }}</span>
                                  
                                </td>

                        </tr>
                        @empty
                           <tr>
                                <td colspan="6"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse
                    @if($stockreadys->links()->paginator->hasPages())
                       <tr>
                        <td colspan="8">
                                <div class="float-right">
                      {{ $stockreadys->links('pagination.custom', ['paginator' => $stockreadys, 'paginationKey' => 'stockready']) }}
                                    </div>
                                </td>  
                            </tr>
                       @endif 


                    </table>
                 

            </div>