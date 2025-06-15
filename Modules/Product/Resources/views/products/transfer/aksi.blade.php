{{--
@can('edit_product_transfer')
<a href="{{ route('products.edit', $data->id) }}" class="btn btn-info btn-sm">
    <i class="bi bi-pencil"></i>
</a>
@endcan


 --}}

 <div class="flex row justify-center items-center">
@can('show_product_transfer')
<a href="{{ route('products.transfer.detail', $data->id) }}" class="btn btn-outline-info btn-sm">
    <i class="bi bi-eye"></i> Tracking
</a>
@endcan
</div>
{{-- @can('delete_products')
<button id="delete" class="btn btn-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
    }
    ">
    <i class="bi bi-trash"></i>
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.destroy', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>
@endcan --}}
