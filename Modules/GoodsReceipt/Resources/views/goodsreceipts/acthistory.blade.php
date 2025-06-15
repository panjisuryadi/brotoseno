<div class="text-center">

  <a href="{{ route("$module_name.show",encode_id($data->id)) }}"

    data-toggle="tooltip"
     class="btn btn-info btn-sm py-1">
        @lang('Detail')
    </a> 

    @can('delete_'.$module_name.'')
    <button id="delete" class="btn btn-danger btn-sm" onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
        }
        ">
       @lang('Hapus')
        <form id="destroy{{ $data->id }}" class="d-none" action="{{ route(''.$module_name.'.destroy', $data->id) }}" method="POST">
            @csrf
            @method('delete')
        </form>
    </button>
@endcan






</div>