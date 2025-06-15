<div class="text-center">

  <a href="{{ route("$module_name.view_produk",encode_id($data->id_produk)) }}"
    data-toggle="tooltip"
    id="DetailProduk"
     class="btn btn-info btn-sm py-1">
       <i class="bi bi-eye"></i>

    </a> 

    <a href="{{ route("products.edit",$data->id_produk) }}"
       data-toggle="tooltip"
       class="btn btn-warning btn-sm py-1">
       <i class="bi bi-pencil"></i>
    </a>


   

    @can('delete_'.$module_name.'')
    <button id="delete" class="btn btn-danger btn-sm" onclick="
        event.preventDefault();
        if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
        }
        ">
        <i class="bi bi-trash"></i>
        <form id="destroy{{ $data->id }}" class="d-none" action="{{ route(''.$module_name.'.destroy', $data->id) }}" method="POST">
            @csrf
            @method('delete')
        </form>
    </button>
@endcan

