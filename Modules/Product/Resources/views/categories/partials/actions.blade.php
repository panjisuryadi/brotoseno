<div class="text-center">
<a href="{{ route('product-categories.edit', $data->id) }}" class="btn btn-info btn-sm">
    <i class="bi bi-pencil"></i>&nbsp;@lang('Edit')
</a>
@if($count_product > 0)
<button class="btn btn-danger btn-sm" onclick="alert('Ada {{ $count_product }} Product yang menggunakan category berikut, hapus dahulu untuk dapat menghapus category');">
    <i class="bi bi-trash"></i>&nbsp;@lang('Delete')
</button>
@else
<button id="delete" class="btn btn-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanentlys!')) {
        document.getElementById('destroy{{ $data->id }}').submit();
    }
    ">
    <i class="bi bi-trash"></i>&nbsp;@lang('Delete')
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('product-categories.destroy', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>
@endif

</div>