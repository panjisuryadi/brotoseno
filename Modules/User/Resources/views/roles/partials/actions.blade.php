<div class="flex items-center text-center">
 <a href="{{ route('roles.edit', $data->id) }}" class="mr-1 btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i>&nbsp;Edit
</a>
<button id="delete" class="btn btn-outline-danger btn-sm " onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
    document.getElementById('destroy{{ $data->id }}').submit();
    }
    ">
    <i class="bi bi-trash"></i>&nbsp;Hapus
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('roles.destroy', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>
</div>