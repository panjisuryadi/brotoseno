<div class="text-center">
<a href="{{ route(''.$module_name.'.edit', $data->id) }}"
id="Edit"
data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i> &nbsp;@lang('Edit') Karat
</a>
</div>

<!-- <div class="text-center">
<a href="{{ route('karats.delete', $data->id) }}"
id="Delete"
data-toggle="tooltip"
 class="btn btn-outline-danger btn-sm">
    <i class="bi bi-trash"></i> &nbsp;@lang('Delete') 
</a>
</div> -->

<form action="{{ route('karats.delete', $data->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" onclick="return confirm('Delete Karat?')">
        <i class="bi bi-trash"></i> &nbsp;@lang('Delete')
    </button>
</form>