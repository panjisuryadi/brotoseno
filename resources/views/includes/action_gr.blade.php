<div class="text-center">

    <a href="{{ route('products.add_products_pembelian', encode_id($data->id)) }}"

    data-toggle="tooltip"
     class="btn btn-info btn-sm">
        <i class="bi bi-pencil"></i> &nbsp;@lang('Tambah Detail')
    </a>


    @can('delete_'.$module_name.'')
    <button id="delete" class="btn btn-danger btn-sm" onclick="
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