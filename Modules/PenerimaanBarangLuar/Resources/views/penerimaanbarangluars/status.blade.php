<div class="text-center">
@can('edit_'.$module_name.'')
    <button
    onclick="showStatus({{$data}})"
    id="Status"
    data-toggle="tooltip"
     class="btn {{bpstts($data->current_status?$data->current_status->name:'PENDING')}} btn-sm uppercase">
       {{$data->current_status?$data->current_status->name:'PENDING'}}
  </button>
@endcan

</div>



