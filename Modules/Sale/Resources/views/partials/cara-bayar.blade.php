<div class="items-center justify-items-center text-center">
@if ($data->tipe_bayar == 'cicilan')
<a 
class="btn uppercase btn-sm btn-info" 
id="Show" 
href="{{ route('sales.show_cicilan', $data->id) }}">
&nbsp;@lang('Cicilan')
</a>
@elseif ($data->status == 'total')
    <span class="badge badge-primary">
        {{ $data->status }}
    </span>
@else
    @foreach ($data->salePayments as $item)
        <span class="uppercase badge 
{{ 
$item->payment_method == 'tunai' ? 'badge-success' 
: ($item->payment_method == 'transfer' ? 'badge-warning' : ($item->payment_method == 'qr' ? 'badge-info' : ($item->payment_method == 'edc' ? 'badge-secondary' : 'success')) ) 

}}">
            {{ $item->payment_method }}
        </span>
    @endforeach
@endif
</div>

