<div class="flex justify-between py-2 border-bottom">

    <div class="w-10 mt-4">
        <a class="link" href="{{ route('home') }}">
            <i class="text-gray-800 bi bi-house-door-fill" style="font-size: 1rem;"></i>
        </a>
    </div>

    <div class="flex-row grid grid-cols-3 gap-1">

        <div class="form-group">
            <label class="mb-0">Scan Produk</label>
            <input type="text" wire:model.debounce.1s="scan_product" class="form-control" placeholder="Scan Produk">
        </div>

        <div class="form-group">
            <label class="mb-0">Kategori</label>
            <select wire:model="category" class="form-control">
                <option value="">Semua Produk</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="mb-0">Jumlah Produk</label>
            <select wire:model="showCount" class="form-control">
                <option value="9">9 Buah</option>
                <option value="15">15 Buah</option>
                <option value="21">21 Buah</option>
                <option value="30">30 Buah</option>
            </select>
        </div>

    </div>




</div>