<div class="items-center justify-items-center text-center">

<!-- Example single danger button -->
<div class="w-full btn-group">
  <button type="button" class="px-5 btn-sm btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Aksi
  </button>
  <div class="dropdown-menu">
     @can('print_sales')
    <a class="dropdown-item" target="_blank" href="{{ route('sales.invoice', $data->id) }}"> <i class="bi bi-printer"></i>&nbsp;@lang('Print')</a>
     @endcan

     @can('show_sales')
    <a class="dropdown-item" href="{{ route('sales.show', $data->id) }}"><i class="bi bi-eye"></i> &nbsp;@lang('View')</a>
      @endcan


    <a class="dropdown-item" href="{{ route('sales.show', $data->id) }}">
       <i class="bi bi-x-square"></i>&nbsp;@lang('Void')</a>

    @can('edit_sales')
        @if ($data->dp_payment && $data->status == 'dp')
            <button id="delete" class="dropdown-item px-2 ml-2 hover:no-underline" onclick="
                event.preventDefault();
                if (confirm('Anda yakin akan melakukan aksi ini?')) {
                document.getElementById('failed{{ $data->id }}').submit()
                }">
                <i class="bi bi-x-square"></i> &nbsp;@lang('Failed')
                <form id="failed{{ $data->id }}" class="d-none" action="{{ route('sales.failed', $data->id) }}" method="POST">
                    @csrf
                    @method('post')
                </form>
            </button>

            <a class="dropdown-item" id="btn-dp" data-toggle="modal" data-target="#pembayaran_dp" data-id ="{{ $data->id }}"  wire:click = "$emitUp('postAdded')" href="#">
                <i class="bi bi-x-square"></i>&nbsp;@lang('Pelunasan DP') </a>
            </a>
        @endif
      @endcan


         @can('delete_sales')
    <button id="delete" class="dropdown-item px-2 ml-2 hover:no-underline" onclick="
                event.preventDefault();
                if (confirm('Are you sure? It will delete the data permanently!')) {
                document.getElementById('destroy{{ $data->id }}').submit()
                }">
                <i class="bi bi-trash"></i> &nbsp;@lang('Delete')
                <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('sales.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </button>
      @endcan
    

  </div>
</div>


</div>


{{-- 


<div class="btn-group dropleft">
    <button type="button" class="btn btn-ghost-primary dropdown rounded" data-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots-vertical"></i>
    </button>
    <div class="dropdown-menu">
        <a target="_blank" href="{{ route('sales.pos.pdf', $data->id) }}" class="dropdown-item">
            <i class="bi bi-file-earmark-pdf mr-2 text-success" style="line-height: 1;"></i> POS Invoice
        </a>
        @can('access_sale_payments')
            <a href="{{ route('sale-payments.index', $data->id) }}" class="dropdown-item">
                <i class="bi bi-cash-coin mr-2 text-warning" style="line-height: 1;"></i> Show Payments
            </a>
        @endcan
        @can('access_sale_payments')
            @if($data->due_amount > 0)
            <a href="{{ route('sale-payments.create', $data->id) }}" class="dropdown-item">
                <i class="bi bi-plus-circle-dotted mr-2 text-success" style="line-height: 1;"></i> Add Payment
            </a>
            @endif
        @endcan
        @can('edit_sales')
            <a href="{{ route('sales.edit', $data->id) }}" class="dropdown-item">
                <i class="bi bi-pencil mr-2 text-primary" style="line-height: 1;"></i> Edit
            </a>
        @endcan
        @can('show_sales')
            <a href="{{ route('sales.show', $data->id) }}" class="dropdown-item">
                <i class="bi bi-eye mr-2 text-info" style="line-height: 1;"></i> Details
            </a>
        @endcan
        @can('delete_sales')
            <button id="delete" class="dropdown-item" onclick="
                event.preventDefault();
                if (confirm('Are you sure? It will delete the data permanently!')) {
                document.getElementById('destroy{{ $data->id }}').submit()
                }">
                <i class="bi bi-trash mr-2 text-danger" style="line-height: 1;"></i> Delete
                <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('sales.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </button>
        @endcan
    </div>
</div>
 --}}