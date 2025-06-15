          <div class="pt-3">
           
        <table style="width: 100%;" class="table table-sm table-striped table-bordered">
            <tr>
                <th class="text-center">{{ label_case('No') }}</th>
             
                <th class="text-center">{{ label_case('Date') }}</th>
                <th class="text-center">{{ label_case('Invoice') }}</th>
                <th class="text-center">{{ label_case('Items') }}</th>
                <th class="text-center">{{ label_case('Status') }}</th>
                <th class="text-center">{{ label_case('Pic') }}</th>
                <th class="text-center">{{ label_case('Aksi') }}</th>
            </tr>
            @php
            $distribusitoko = \Modules\DistribusiToko\Models\DistribusiToko::inprogress()->latest()->paginate(10, ['*'], 'distribusitoko');
            @endphp
            @forelse($distribusitoko as $row)
            {{--     @if($loop->index > 4)
            @break
            @endif
            --}}
            {{-- {{ $row }} --}}
            <tr>
                <td>{{ $loop->iteration }}</td>
               
                <td>{!!tgljam($row->created_at) !!}</td>
                <td>{{ $row->no_invoice }}</td>
                <td>{{ $row->items->count() }}</td>
                <td>
                    @if($row->current_status->id == 2)
                    <button class="w-full btn uppercase btn-outline-warning px  leading-5 btn-sm">In Progress</button>
                    @endif
                </td>
                <td>{{ $row->created_by }}</td>
                <td class="text-center">
                    <a  href="{{ route('distribusitoko.detail_distribusi', $row->id) }}" class="btn btn-success px-4 btn-sm w-full">
                        <i class="bi bi-eye"></i> Approve
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8"> <p class="uppercase">Tidak ada Data</p></td>
            </tr>
               @endforelse
                  @if($distribusitoko->links()->paginator->hasPages())
                    <tr>
                        <td colspan="8">
                            <div class="float-right">
                  {{ $distribusitoko->links('pagination.custom', ['paginator' => $distribusitoko, 'paginationKey' => 'distribusitoko']) }}
                            </div>
                        </td>  
                    </tr>
                    @endif 
                </table>
                </div>