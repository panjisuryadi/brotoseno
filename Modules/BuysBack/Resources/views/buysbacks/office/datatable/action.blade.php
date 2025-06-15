<div class="text-center">
@if ($data->isSent())
<a href="#"
    class="btn btn-success btn-sm" onclick="process({{$data}})">
    <i class="bi bi-eye"></i> &nbsp;@lang('Process')
</a>
@elseif ($data->isProcessing())
<a href="{{ route(''.$module_name.'.show', $data->id) }}"
    class="btn btn-success btn-sm">
    <i class="bi bi-eye"></i> &nbsp;@lang('Process')
</a>
@endif
</div>