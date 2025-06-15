 <div class="justify-center text-center items-center">
@if($data->status == 2)
<button class="relative btn btn-sm btn-outline-secondary" disabled>
     &nbsp;@lang('Sortir')
      <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip"
      data-placement="top" title="Barang belum di Approve,tidak bisa sortir..!!"></i>
</button>
@else
 <a href="{{ route(''.$module_name.'.show_sortir', $data->id) }}"
    id="Sortir"
    data-toggle="tooltip"
     class="btn btn-outline-success py-1 btn-sm">
        <i class="bi bi-eye"></i> &nbsp;@lang('Sortir')

    </a>
@can('show_tracking_products')
<a href="{{ route('products.transfer.detail', $data->id) }}" class="btn btn-outline-info btn-sm">
    <i class="bi bi-eye"></i> Tracking
</a>
@endcan


@endif





@can('delete_products')
<button id="delete" class="px-2 py-1 btn btn-outline-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
    }
    ">
    <i class="bi bi-trash"></i>&nbsp;@lang('Delete')
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.destroy', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>
@endcan
</div>