<div class="text-center">
    <a href="{{ route(''.$module_name.'.status', $data->id) }}"
    id="Status"
    data-toggle="tooltip"
     class="btn {{bpstts($data->current_status?$data->current_status->name:'PENDING')}} btn-sm uppercase">
       {{$data->current_status?$data->current_status->name:'PENDING'}}
    </a>


</div>