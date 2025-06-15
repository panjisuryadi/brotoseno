<div class="text-center">
@if ($data->isSent())
<a href="#"
    class="btn btn-success btn-sm" onclick="process({{$data}})">
    <i class="bi bi-eye"></i> &nbsp;@lang('Process')
</a>
@else
<a href="{{ route(''.$module_name.'.toko.buyback-barangluar.nota.show', $data->id) }}"
    class="btn btn-info btn-sm">
    <i class="bi bi-eye"></i> &nbsp;@lang('Detail')
</a>
@endif
</div>