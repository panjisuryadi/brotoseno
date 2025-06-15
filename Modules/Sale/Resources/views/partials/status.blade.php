<div class="items-center justify-items-center text-center">
<span class="uppercase badge badge-{{ $data->status == 'dp' ? 'warning' : ($data->status == 'failed' ? 'danger' : 'success') }}">
    {{ empty($data->status) ? 'completed' : ($data->status == 'failed' ? 'dp failed' : $data->status ) }}
</span>
</div>