@can('delete_products')
<!-- <button id="delete" class="btn btn-outline-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
    }
    ">
    <i class="bi bi-trash"></i>&nbsp;
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.delete', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button> -->
@if($data->status == 2 || $data->status == 10 || $data->status == 15)

@else
<button class="btn btn-outline-danger btn-sm" onclick="openPasswordModal2(event, '{{ $data->id }}')">
    <i class="bi bi-trash"></i>
</button>
@endif
<!-- <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.delete', $data->id) }}" method="POST">
    @csrf
    @method('delete')
</form> -->
@endcan

<div class="text-center">
<a href="#" data-toggle="modal" data-target="#lihatModal_{{$data->id}}"

data-toggle="tooltip"
 class="btn btn-outline-info btn-sm">
    <i class="bi bi-eye"></i>
</a>
</div>

<div class="btn-group">
    <a href="#" class="px-3 btn btn-sm btn-success" data-toggle="modal" data-target="#updateModal" onclick="show_modal({{ $data->id }});">
        <i class="bi bi-pencil"></i>
    </a>
</div>

<div class="btn-group">
    <!-- edit_modal(id, image, category, model, group, karat, berat, baki) -->
    <a href="#" class="px-3 btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal" 
    onclick="edit_modal(
        {{ $data->id }},
        '{{ $data->images }}',
        '{{ $data->category->id ?? '' }}',
        '{{ $data->model->id ?? '' }}',
        '{{ $data->group->id ?? '' }}',
        '{{ $data->karat->id ?? '' }}',
        '{{ $data->berat_emas }}',
        '{{ $data->baki->id ?? '' }}'
    );">
        <i class="bi bi-pencil"></i>
    </a>
</div>

<div class="btn-group">
    <!-- edit_modal(id, image, category, model, group, karat, berat, baki) -->
    <a href="#" class="px-3 btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal" >
        <i class="bi bi-pencil"></i>
    </a>
</div>


<div class="modal fade" id="lihatModal_{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Detail Product {{$invoice}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-6">
                        <div class="px-0 py-2">
                            <div class="col-span-2 px-2">
                                <div class="flex flex-row grid grid-cols-2 gap-1">
                                    <div class="form-group">
                                        <?php
                                            $image = $data->images;
                                            $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                        ?>
                                        <img src="{{ $imagePath }}" order="0" width="175" class="img-thumbnail"/>
                                    </div>
                                                
                                    <div class="form-group">
                                        <label for="product_category">Product Category</label>
                                        @php
                                        $category   = $data->category->category_name ?? '-';
                                        @endphp
                                        <input type="text" class="form-control" value="{{$category}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Product Model</label>
                                        <input type="text" class="form-control" value="{{$data->model->name}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Product Karat</label>
                                        <?php
                                        $kar    = $data->karat->name ?? '';
                                        $kod    = $data->karat->kode ?? ''; 
                                        $ka     = $kar.' | '.$kod;
                                        ?>
                                        <input type="text" class="form-control" value="{{$ka}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Product Group</label>
                                        <input type="text" class="form-control" value="{{$data->group->name}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Product Code</label>
                                        <input type="text" class="form-control" value="{{$data->product_code}}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Berat</label>
                                        <input type="text" class="form-control" value="{{$data->berat_emas}} gr" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_category">Baki</label>
                                        <input type="text" class="form-control" value="{{$data->baki->name ?? '-'}}" readonly>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="px-0 py-2">
                            @php
                                $sold   = 0;
                                $buyback= 0;
                                $stat['O'] = 'Ready';
                                $stat['S'] = 'Sold';
                                $stat['P'] = 'Pending';
                                $stat['B'] = 'Buyback';
                                $stat['C'] = 'Cuci';
                                $stat['M'] = 'Lebur';
                                $stat['K'] = 'Rongsok';
                                $stat['R'] = 'Reparasi';
                                $stat[2] = 'Second';
                                $stat['L'] = 'Hilang';
                                $stat[11] = 'Draft';
                                $stat[12] = 'Dalam Perjalanan';
                                $stat[13] = 'Ready Office';
                                $stat[14] = 'DP';
                                $stat[15] = 'Removed';
                                $stat['H'] = 'Hancur Lebur';
                                $stat['L'] = 'Barang Luar';
                            @endphp
                            @foreach($history as $h)
                                @if($h->status == 'S')
                                    @php $sold++; @endphp
                                @elseif($h->status == 'B')
                                    @php $buyback++; @endphp
                                @endif
                            @endforeach
                            <h2 class="mb-1">Sold : {{$sold}} | Buyback : {{$buyback}}</h2>
                            <div style="max-height: 400px; overflow-y: auto;">
                                <table class="table" class="table mt-2">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Tanggal</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($history as $h)
                                        <tr>
                                            <td>{{$stat[$h->status]}}</td>
                                            <td>{{$h->keterangan}}</td>
                                            <td>{{$h->tanggal}}</td>
                                            <td>{{number_format($h->harga)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="delete-password" class="form-label">Enter password to confirm:</label>
        <input type="password" id="delete-password" class="form-control" placeholder="Password">
        <div id="password-error" class="text-danger mt-2 d-none">Wrong password!</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="confirmPasswordAndDelete()">Confirm</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">Update Status Product</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form action="/products_updatestatus" method="post">
                    @csrf
                    <div class="px-0 py-2">
                    @php
                    $number = 0;
                    @endphp
                    <div class="col-span-2 px-2">
                        <div class="flex flex-row grid grid-cols-2 gap-1">
                            <div class="form-group">
                                <label for="product_category">Status</label>
                                <input type="hidden" name="product" id="product" value="reparasi">
                                <input type="hidden" name="id" id="id">
                                <select name="status" id="status" onchange="rubah_harga();" class="form-control" required>
                                    <option value="1">Ready</option>
                                    <option value="3">Pending</option>
                                    <option value="5">Cuci</option>
                                    <option value="6">Masak</option>
                                    <option value="8">Reparasi</option>
                                    <option value="15">Lebur/Removed</option>
                                </select>
                            </div>

                            <div class="form-group" id="div_reparasi" style="display: none;">
                                <label for="">Harga (Khusus Reparasi)</label>
                                <input type="number" id="harga" class="form-control" name="harga">
                            </div>

                            <div class="form-group" id="div_baki">
                                <label for="baki">Baki</label>
                                <select name="baki" id="baki" class="form-control">
                                    @foreach($baki as $b)
                                    <option value="{{$b->id}}">{{$b->name}}</option>
                                    @endforeach
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
    let deleteFormId = null;

    function openPasswordModal2(event, id) {
        event.preventDefault();
        deleteFormId = 'destroy' + id;
        document.getElementById('delete-password').value = '';
        document.getElementById('password-error').classList.add('d-none');
        let modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    }

    function confirmPasswordAndDelete() {
        const enteredPassword = document.getElementById('delete-password').value;
        const correctPassword = 'luvenia12345'; // ⚠️ Replace this with a secure check or variable!

        if (enteredPassword === correctPassword) {
            document.getElementById(deleteFormId).submit();
        } else {
            document.getElementById('password-error').classList.remove('d-none');
        }
    }

    function show_modal(id){
        $("#id").val();
        $("#id").val(id);
    }
    
    function rubah_harga(){
        // $('#harga').prop('disabled', true);
        $('#div_reparasi').hide();
        $('#div_baki').hide();

        if($("#status").val() == 8){
            $('#div_reparasi').show();
        }else if($("#status").val() == 1){
            $('#div_baki').show();
        }
    }
</script>