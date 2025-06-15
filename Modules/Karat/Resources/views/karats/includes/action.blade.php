<div class="text-center">
@can('edit_'.$module_name.'')
<a href="{{ route(''.$module_name.'.edit', $data->id) }}"
id="Edit"
data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-pencil"></i> &nbsp;@lang('Edit') Karat
</a>
@endcan
</div>