    <div class="justify-center text-center items-center">


<div class="btn-group justify-center text-center items-center dropleft">

  <div class="dropdown-menu " style="z-index: 9;">
        @can('access_purchase_payments')
            <a href="{{ route('purchase-payments.index', $data->id) }}" class="px-2 py-1 dropdown-item">
                <i class="bi bi-cash-coin mr-2 text-warning" style="line-height: 1;"></i> Show Payments
            </a>
        @endcan
        @can('access_purchase_payments')
            @if($data->due_amount > 0)
                <a href="{{ route('purchase-payments.create', $data->id) }}" class="px-2 py-1 dropdown-item">
                    <i class="bi bi-plus-circle-dotted mr-2 text-success" style="line-height: 1;"></i> Add Payment
                </a>
            @endif
        @endcan
        @can('edit_purchases')
            <a href="{{ route('purchases.edit', $data->id) }}" class="px-2 py-1 dropdown-item">
                <i class="bi bi-pencil mr-2 text-primary" style="line-height: 1;"></i> Edit
            </a>
            @if($data->status != 'Completed')
            <a href="javascript:;" onclick="completepurchase('{{$data->id}}','{{$data->reference}}')" class="dropdown-item">
                <i class="bi bi-bag-check mr-2 text-primary" style="line-height: 1;"></i> Complete Purchase
            </a>
            @endif
        @endcan
        @can('show_purchases')
            <a href="{{ route('purchases.show', $data->id) }}" class="px-2 py-1 dropdown-item">
                <i class="bi bi-eye mr-2 text-info" style="line-height: 1;"></i> Details
            </a>
        @endcan
        @can('delete_purchases')
            <button id="delete" class="px-2 py-1 dropdown-item" onclick="
                event.preventDefault();
                if (confirm('Are you sure? It will delete the data permanently!')) {
                document.getElementById('destroy{{ $data->id }}').submit()
                }">
                <i class="bi bi-trash mr-2 text-danger" style="line-height: 1;"></i> Delete
                <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('purchases.destroy', $data->id) }}" method="POST">
                    @csrf
                    @method('delete')
                </form>
            </button>
        @endcan
    </div>


    <button type="button" class="btn btn-ghost-primary dropdown rounded" data-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-three-dots-vertical"></i>
    </button>




</div>




    </div>


