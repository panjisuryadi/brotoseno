<div class="btn-group">
    <a href="#" class="px-3 btn btn-warning" data-toggle="modal" data-target="#editModal" onclick="show_modal({{ $data->id }}, '{{ $data->name }}');">
        <i class="bi bi-pencil"></i>
    </a>
</div>
@if ($data->status == 'A')
<div class="btn-group">
    
    <form action="{{ route('pabrics.delete', ['id' => $data->id]) }}" method="POST" onsubmit="return confirm('Yakin Hapus [{{$data->name}}]?');">
        
        @csrf 

        @method('DELETE') 

        <button type="submit" class="px-3 btn btn-danger">
            <i class="bi bi-trash"></i> 
        </button>
    </form>

</div>
@endif



<script>

</script>
