@if($data->status == 'A')
<div class="btn-group">
    <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#editModal" onclick="detail_modal('{{$data->id}}');">
        + Modal<i class="bi bi-edit"></i>
    </a>
</div>
@endif


