<div class="text-center">
@can('edit_'.$module_name.'')
    <a id="Detail" href="{{ route(''.$module_name.'.gudang-office.detail', $data) }}"
     class="btn btn-outline-success btn-sm">
        <i class="bi bi-eye"></i> &nbsp;@lang('Detail')
    </a>
@endcan
</div>