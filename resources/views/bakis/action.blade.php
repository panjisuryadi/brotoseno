<div class="btn-group">
    <a href="#" class="px-3 btn btn-warning" data-toggle="modal" data-target="#editModal" onclick="show_modal({{ $data->id }}, '{{ $data->code }}', '{{ $data->posisi }}', '{{ $data->name }}', '{{ $data->capacity }}');">
        Edit <i class="bi bi-edit"></i>
    </a>
</div>
@if ($data->status == 'A')
<div class="btn-group">
    <a href="./products_baki/{{ $data->id }}" class="px-3 btn btn-info" target="_blank">
        Detail <i class="bi bi-edit"></i>
    </a>
</div>
@endif

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Update Baki</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/bakis/update" method="post">
                    @csrf
                    <div class="px-0 py-2">
                        @php
                        $number = 0;
                        @endphp
                        <div class="col-span-2 px-2">
                            <div class="flex flex-row grid grid-cols-2 gap-1">
                                <div class="form-group">
                                    <label for="">Code</label>
                                    <input type="hidden" name="id" id="id">
                                    <input type="text" class="form-control" name="code" id="code" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Posisi</label>
                                    <select name="posisi" id="posisi" class="form-control">
                                        <option value="etalase">Etalase</option>
                                        <option value="brankas">Brankas</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Capacity</label>
                                    <input type="number" class="form-control" name="capacity" id="capacity" required>
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
function show_modal(id, code, posisi, name, capacity){
    // console.log(code);
    // console.log(name);
    // console.log(capacity);

    document.getElementById("id").value = id;
    document.getElementById("code").value = code;
    document.getElementById("posisi").value = posisi;
    document.getElementById("name").value = name;
    document.getElementById("capacity").value = capacity;
}
</script>
