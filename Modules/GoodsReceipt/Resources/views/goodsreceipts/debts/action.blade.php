<div class="text-center">
    {{-- @can('edit_'.$module_name.'') --}}
        <a href="{{ route(''.$module_name.'.edit_status', $data->id) }}"
        id="edit_status"
        data-toggle="tooltip"
        class="btn btn-outline-info btn-sm {{ !empty($data->pembelian->lunas) && !empty($data->pembelian->tipe_pembayaran) || $data->pembelian->tipe_pembayaran == 'lunas' ? 'disabled' : '' }}">
            &nbsp;@lang('Bayar')
        </a>
    {{-- @endcan --}}

<a href="{{ route("$module_name.show",encode_id($data->id)) }}"

    data-toggle="tooltip"
     class="btn btn-outline-info btn-sm py-1">
        @lang('Detail')
    </a> 
</div>