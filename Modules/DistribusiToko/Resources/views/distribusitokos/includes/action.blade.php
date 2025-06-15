<div class="text-center">

<a target="_blank" href="{{ route(''.$module_name.'.view_excel', $data->id) }}"
    class="btn btn-outline-success btn-sm">
    <i class="bi bi-file-excel"></i> &nbsp;@lang('Export')
</a>


{{-- 
<a target="_blank" href="{{ route(''.$module_name.'.export_emas_detail', $data->id) }}"
    class="btn btn-outline-success btn-sm">
    <i class="bi bi-eye"></i> &nbsp;@lang('Export')
</a>

 --}}

@can('show_distribusitoko')
<a href="{{ route(''.$module_name.'.detail', $data->id) }}"
    class="btn btn-outline-primary btn-sm">
    <i class="bi bi-eye"></i> &nbsp;@lang('View')
</a>
@endcan

@can('delete_distribusitoko')

<!-- @if ($data->isDraft())
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
@endif -->
@endcan






</div>