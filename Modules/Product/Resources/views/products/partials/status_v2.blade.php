<div class="flex row justify-center items-center px-3">
{{-- {{$data->status_id}} --}}
@if($data->status_id == 2)
<a id="Approve" href="{{ route('products.transfer.approve', $data->id) }}" class="btn btn-outline-warning btn-sm"> Sold
</a>
@elseif($data->status_id == 3)
<button class="btn btn-outline-success px  btn-sm">Pending</button>

@elseif($data->status_id == 4)
<button class="btn btn-outline-danger px  btn-sm">Gudang Utama</button>

@elseif($data->status_id == 1)
<button class="btn btn-success px btn-sm">Ready</button>

@elseif($data->status_id == 8)
<button class="btn btn-success px btn-sm">Reparasi</button>

@elseif($data->status_id == 0)
<button class="btn btn-info px  btn-sm p-1 text-xs">In Progress</button>
@endif

</div>
