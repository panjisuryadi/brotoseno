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
    
    <button id="delete" class="btn btn-outline-danger btn-sm" onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
        }
        ">
        @lang('Hapus')
        <form id="destroy{{ $data->id }}" class="d-none" action="{{ route(''.$module_name.'.debts_destroy', $data->id) }}" method="POST">
            @csrf
            @method('delete')
        </form>
    </button>

</div>
