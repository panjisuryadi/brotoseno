@can('show_products')
<a href="{{ route('products.show', $data->id) }}" class="btn btn-outline-success btn-sm">
    <i class="bi bi-eye"></i>&nbsp;Detail
</a>
@endcan
@can('delete_products')
<button id="delete" class="btn btn-outline-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
    }
    ">
    <i class="bi bi-trash"></i>&nbsp;Hapus
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.destroy', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>
@endcan
