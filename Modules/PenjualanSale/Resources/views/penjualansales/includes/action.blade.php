<div class="text-center">
@can('access_bayar_penjualan_sales')

    <a href="{{ route(''.$module_name.'.edit_status', $data->id) }}"
        id="edit_status"
        data-toggle="tooltip"
        class="btn btn-outline-info btn-sm {{ empty($data->payment) || ((!empty($data->payment->lunas) || !empty($data->payment->tipe_pembayaran) || $data->payment->tipe_pembayaran == 'lunas')) ? 'disabled' : '' }}">
            &nbsp;@lang('Bayar')
    </a>
@endcan


@can('show_penjualansales')
    <a href="{{ route(''.$module_name.'.show', $data->id) }}"
     class="btn btn-outline-success btn-sm">
        <i class="bi bi-eye"></i> &nbsp;@lang('View')
    </a>
@endcan




    @can('delete_penjualansales')
    <button id="delete" class="btn btn-outline-danger btn-sm" onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
        }
        ">
        <i class="bi bi-trash"></i>&nbsp;@lang('Delete')
        <form id="destroy{{ $data->id }}" class="d-none" action="{{ route(''.$module_name.'.destroy', $data->id) }}" method="POST">
            @csrf
            @method('delete')
        </form>
    </button>
@endcan
</div>