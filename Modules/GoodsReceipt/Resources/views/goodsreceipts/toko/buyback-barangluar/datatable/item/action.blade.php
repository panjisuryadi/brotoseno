<div class="text-center">

    <a href="{{ route(''.$module_name.'.toko.buyback-barangluar.print', $data->id) }}"
     class="btn btn-outline-info btn-sm">
        <i class="bi bi-printer"></i> &nbsp;@lang('Print')
    </a>

    @can('delete_buybacktoko')
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