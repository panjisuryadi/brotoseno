<div class="flex row justify-center items-center px-3">
{{-- {{$data->current_status->id}} --}}
@if($data->current_status->id == 2)
<button class="w-full btn uppercase btn-outline-warning px  leading-5 btn-sm">In Progress</button>

@elseif($data->current_status->id == 3)
<button class="w-full btn uppercase btn-outline-danger px  btn-sm">Retur</button>

@elseif($data->current_status->id == 4)
<button class="w-full btn uppercase btn-outline-info px btn-sm">Completed</button>

@elseif($data->current_status->id == 1)
<button class="w-full btn uppercase btn-success px btn-sm">Draft</button>
@endif

</div>
