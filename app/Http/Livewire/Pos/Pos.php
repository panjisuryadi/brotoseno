<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class Pos extends Component
{
    public $categories;
    public $category_id = '';

    public $limit = 10;
    public $perPage = 2;
    public $hasPages = true;
    public $maxPages = 125;
    public $search = '';

    public $load_more_number = 0;

    public function render()
    {
        $products = Product::akses()->with('karat.penentuanHarga')
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })
            ->when($this->search, function ($query) {
                return $query->where('product_name', 'like', '%' . $this->search . '%');
            })
            ->where('status_id', ProductStatus::READY)
            ->take($this->perPage)->get();
        $this->canLoadMore = (count($products) < $this->limit);
        return view('livewire.pos.pos', [
            'products' => $products
        ]);
    }

    public function mount()
    {
        $this->load_more_number = $this->perPage;
        $this->categories = Category::all();
    }

    public function loadMore()
    {
        $this->perPage += $this->load_more_number;
        $this->render();
    }

}
