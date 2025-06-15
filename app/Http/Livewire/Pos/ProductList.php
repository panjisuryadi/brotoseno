<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'selectedCategory' => 'categoryChanged',
        'showCount'        => 'showCountChanged',
        'productScanned' => 'addToCart'
    ];

    public $categories;
    public $category_id;

    public $limit = 9;

    public function mount($categories) {
        $this->categories = $categories;
        $this->category_id = '';
    }

    public function render() {

             $products = Product::akses()->with('karat.penentuanHarga')
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })->where('status_id', ProductStatus::READY)
            ->paginate($this->limit);



        return view('livewire.pos.product-list', [

            'products' => $products
        ]);
    }

    public function categoryChanged($category_id) {
        $this->category_id = $category_id;
        $this->resetPage();
    }

    public function showCountChanged($value) {
        $this->limit = $value;
        $this->resetPage();
    }

    public function addToCart($value){
        $product = Product::akses()->with('karat.penentuanHarga')
                    ->where('status_id', ProductStatus::READY)
                    ->where('product_code', $value)
                    ->first();
        if(!empty($product)){
            $this->selectProduct($product);
        }
    }

    public function selectProduct($product) {
       // dd($product);
        $this->emit('productSelected', $product);
    }
}