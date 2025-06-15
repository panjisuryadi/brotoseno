    <div class="pt-3">

                   <table style="width: 100%;" class="table table-sm table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th class="text-center">{{ label_case('Date') }}</th>
                            <th>{{ label_case('Produk') }}</th>
                            <th>{{ label_case('Karat') }}</th>
                            <th>{{ label_case('Status') }}</th>

                        </tr>

              @php
            $product =\Modules\Product\Entities\Product::ready()->latest()->paginate(2);
            @endphp   
                    @forelse($product as $row)
                       {{--  @if($loop->index > 4)
                             @break
                         @endif --}}
                           {{-- {{ $row }} --}}

                           <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{!!tgljam($row->created_at) !!}</td>
                                <td>{{ @$row->product_name }}</td>
                                <td>{{ @$row->karat?->label }}</td>
                                <td>
                                    <span class="bg-green-500 px-2 py-1 text-center text-white uppercase rounded-md">  {{ @$row->product_status->name }}</span>
                                  
                                </td>

                        </tr>
                        @empty
                           <tr>
                                <td colspan="6"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                      @if($product->links()->paginator->hasPages())
                       <tr>
                        <td colspan="8">
                                <div class="float-right">
                      {{ $product->links('pagination.custom', ['paginator' => $product, 'paginationKey' => 'sales']) }}
                                    </div>
                                </td>  
                            </tr>
                       @endif 

                 
                    </table>

      

            </div>