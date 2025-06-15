<div class="flex row justify-center items-center">
@can('access_approve_product')
@if($data->status == 2)
<a id="Approve" href="{{ route('products.transfer.approve', $data->id) }}" class="btn btn-outline-warning btn-sm"> Need Approve
</a>
@elseif($data->status == 3)
<button class="btn btn-outline-success btn-sm">Approved</button>

@elseif($data->status == 4)
<button class="btn btn-outline-danger btn-sm">Rejected</button>

@elseif($data->status == 1)
<button class="btn btn-outline-success btn-sm">Aktif</button>

@elseif($data->status == 0)
<button class="btn btn-outline-danger btn-sm p-1 text-xs">Purchase</button>


@endif

@endcan
</div>
