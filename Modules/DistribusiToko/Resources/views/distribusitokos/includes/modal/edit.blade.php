<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title text-lg font-bold" id="addModalLabel">Edit Draft Item</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" name="data_id" id="data_id">
                <div class="grid grid-cols-3 gap-2">
                    <div class="form-group">
                        <label for="product_category">Product Category</label>
                        <select id="product_category" class="form-control @error('product_category') is-invalid @enderror">
                        <option value="" disabled>Semua Produk</option>
                            @php
                                $kategori = \Modules\KategoriProduk\Models\KategoriProduk::where('slug','gold')->orWhere('slug','emas')->firstOrFail();
                                $categories = \Modules\Product\Entities\Category::where('kategori_produk_id',$kategori->id)->get();
                            @endphp
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('product_category'))
                            <span class="invalid feedback"role="alert">
                                <small class="text-danger">{{ $errors->first('product_category') }}.</small
                                class="text-danger">
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="group">@lang('Group')
                            <span class="text-danger">*</span>
                            <span class="small">Jenis Perhiasan</span>
                        </label>
                        <select class="form-control @error('group') is-invalid @enderror" name="group" id="group">
                            <option value="" selected disabled>Pilih Group</option>
                            @foreach(\Modules\Group\Models\Group::all() as $jp)
                            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('group'))
                        <span class="invalid feedback"role="alert">
                            <small class="text-danger">{{ $errors->first('group') }}.</small
                            class="text-danger">
                        </span>
                        @endif

                    </div> 


                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" onclick="addtolist()">Tambahkan</button>
        </div>
        </div>
    </div>
</div>