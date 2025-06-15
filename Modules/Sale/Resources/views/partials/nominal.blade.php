<div class="items-center justify-items-center text-center">
@if ($data->tipe_bayar == 'cicilan')
    <span class="text-center text-dark">
       {{ rupiah($data->total_amount) }}
       <div>  {{ shortdate($data->tgl_jatuh_tempo) }} </div>
    </span>
@elseif ($data->status == 'total')
    <span class="badge badge-primary">
        {{ $data->status }}
    </span>
@else
    <span class="text-center text-dark">
        {{ rupiah($data->total_amount) }}
    </span>
@endif
</div>