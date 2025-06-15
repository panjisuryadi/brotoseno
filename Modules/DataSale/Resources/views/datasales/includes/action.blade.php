<div class="text-center">
@can('edit_'.$module_name.'')
    <a href="{{ route(''.$module_name.'.show', $data->id) }}"
     class="btn btn-outline-success btn-sm">
        <i class="bi bi-eye"></i> &nbsp;@lang('View')
    </a>

@endcan

@can('edit_'.$module_name.'')
    <a href="{{ route(''.$module_name.'.edit', $data->id) }}" class="btn btn-outline-nfo btn-sm">
        <i class="bi bi-pencil"></i> &nbsp;@lang('Update')
    </a>
@endcan
</div>