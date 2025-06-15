@if($data->status == 'A')
<div class="btn-group">
    <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#editModal" onclick="detail_modal('{{$data->id}}');">
        +<i class="bi bi-add"></i>
    </a>
</div>

<div class="btn-group">
    <a href="#" class="px-3 btn btn-warning" data-toggle="modal" data-target="#closeModal" onclick="close_modal('{{$data->id}}');">
        x<i class="bi bi-close"></i>
    </a>
</div>

@endif
<div class="btn-group">
    <a href="./pettycash/detail/{{$data->id}}" class="px-3 btn btn-info">
        i<i class="bi bi-view"></i>
    </a>
</div>

