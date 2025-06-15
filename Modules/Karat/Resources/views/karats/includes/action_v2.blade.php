<div class="text-center">
@if (empty($data->parent_id))
@can('edit_'.$module_name.'')
<a href="{{ route(''.$module_name.'.edit', $data->id) }}"
id="Edit"
data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i> &nbsp;@lang('Edit') Coef
</a>
@endcan
@endif
</div>