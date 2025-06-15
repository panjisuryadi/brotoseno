<?php

namespace App\Http\Livewire\Adjustment;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;

class ListProduct extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $limitPerPage = 4;
    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 1;
    }

    // public $limit = 5;
    // public function render() {

    //     return view('livewire.adjustment.list-product', [
    //         'products' => Product::latest()->paginate($this->limit) ]);

    //       }

public function render()
    {
        $products = Product::latest()->paginate($this->limitPerPage);
        $this->emit('userStore');
        return view('livewire.adjustment.list-product', ['products' => $products]);
    }





    public function showCountChanged($value) {
        $this->limit = $value;
        $this->resetPage();
    }

    public function selectProduct($product) {
        $this->emit('productSelected', $product);
    }
}
