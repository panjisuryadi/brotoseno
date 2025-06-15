<div class="btn-group">
    <a href="#" class="px-3 btn btn-danger" data-toggle="modal" data-target="#createModal" onclick="show_modal({{ $data->id }});">
        Status <i class="bi bi-plus"></i>
    </a>
</div>


<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Update Status Product</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/products_updateall" method="post">
                    @csrf
                    <div class="px-0 py-2">
                                @php
                                $number = 0;
                                @endphp
                                <div class="col-span-2 px-2">
                                    <div class="flex flex-row grid grid-cols-2 gap-1">
                                        <div class="form-group">
                                            <label for="product_category">Status</label>
                                            <input type="hidden" name="id" id="id">
                                            <select name="status" id="status" onchange="rubah_harga();" class="form-control" required>
                                                <option value="1">Ready</option>
                                                <option value="4">Pending Office</option>
                                                <option value="5">Cuci</option>
                                                <option value="6">Masak</option>
                                                <option value="8">Reparasi</option>
                                                <option value="15">Lebur/Removed</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="product_category">Harga (Khusus Reparasi)</label>
                                            <input type="number" id="harga" class="form-control" name="harga" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="product_category">Baki</label>
                                            <select name="baki" id="baki" class="form-control">
                                            <!-- @if (isset($baki)) -->
                                                @foreach($baki as $index => $b)
                                                    <option value="{{$b->id}}">{{$b->name}}</option>
                                                @endforeach
                                            <!-- @endif -->
                                            </select>
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
function show_modal(id){
    $("#id").val();
    $("#id").val(id);
}

function rubah_harga(){
    $('#harga').prop('disabled', true);
    if($("#status").val() == 8){
        $('#harga').prop('disabled', false);
    }
}
</script>
