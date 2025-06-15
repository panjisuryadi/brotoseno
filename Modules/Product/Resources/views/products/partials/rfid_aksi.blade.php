{{-- @can('edit_products')
<a href="{{ route('products.edit', $data->id) }}" class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i>
</a>
@endcan --}}
@can('show_products')

 <a href="{{ route(''.$module_name.'.show_rfid', $data->id) }}"
    id="Sortir"
    data-toggle="tooltip"
     class="btn btn-outline-info btn-sm">
        <i class="bi bi-eye"></i> &nbsp;@lang('RFID')
    </a>


@endcan
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
