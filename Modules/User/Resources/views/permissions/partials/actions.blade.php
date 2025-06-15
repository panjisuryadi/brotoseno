<a href="{{ route('permissions.edit', $data->id) }}" id="Edit" class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i></a>
<button id="delete" class="btn btn-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
    document.getElementById('destroy{{ $data->id }}').submit();
    }
    ">
    <i class="bi bi-trash"></i>
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('permissions.destroy', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>

{{-- <a href="{{ route('permission.edit', $data->id) }}" class="btn btn-info btn-sm">
    <i class="bi bi-pencil"></i>
</a>

<button id="delete" class="btn btn-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
    document.getElementById('destroy{{ $data->id }}').submit();
    }
    ">
    <i class="bi bi-trash"></i>
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('permission.destroy', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>
 --}}