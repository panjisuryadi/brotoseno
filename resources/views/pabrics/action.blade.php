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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Update Pabrik</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('pabrics.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    @method('PUT') 
                    <div class="px-0 py-2">
                        @php
                        $number = 0;
                        @endphp
                        <div class="col-span-2 px-2">
                            <div class="flex flex-row grid grid-cols-2 gap-1">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                            </div>

                            {{-- ///batas --}}
                            
                        </div>
                        <button class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function show_modal(id, name){
    document.getElementById("id").value = id;
    document.getElementById("name").value = name;
}
</script>
