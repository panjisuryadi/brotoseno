<div class="text-center">
@can('edit_'.$module_name.'')
    <a href="{{ route(''.$module_name.'.show', $data->id) }}"
    id="Show"
    data-toggle="tooltip"
     class="btn btn-outline-success btn-sm">
        <i class="bi bi-eye"></i> &nbsp;@lang('View')
    </a>



@endcan

    @can('delete_'.$module_name.'')
    <button id="delete" class="btn btn-outline-danger btn-sm" onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
        }
        ">
        <i class="bi bi-trash"></i>&nbsp;@lang('Delete')
        <form id="destroy{{ $data->id }}" class="d-none" action="{{ route(''.$module_name.'.destroy', $data->id) }}" method="POST">
            @csrf
            @method('delete')
        </form>
    </button>
@endcan






</div>