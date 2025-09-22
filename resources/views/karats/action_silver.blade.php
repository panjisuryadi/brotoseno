<div class="text-center">
@if (empty($data->parent_id))
@can('edit_'.$module_name.'')
<a href="{{ route('silver.edit', ['id' => $data->id]) }}"
id="Edit"
data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i> &nbsp;@lang('Edit')
</a>

<!-- <a href="{{ route('lm.delete', ['id' => $data->id]) }}"
id="Edit"
data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i> &nbsp;@lang('Delete')
</a> -->
@endcan
@endif
</div>