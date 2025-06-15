@if($data->status == 'W' || $data->status == 'P')
<div class="btn-group">
    <a href="./stockopname/detail/{{ $data->id }}" class="px-3 btn btn-danger" target="_blank" onclick="return confirm('Yakin Opname Baki ini ?');">
        Opname <i class="bi bi-edit"></i>
    </a>
</div>
@endif
