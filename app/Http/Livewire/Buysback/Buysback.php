<?php

namespace App\Http\Livewire\Buysback;

use Livewire\Component;
use Illuminate\Support\Collection;
use Modules\Product\Entities\Product;


class Buysback extends Component
{

    public $query;
    public $type;
    public $search_results;
    public $list_product;
    public $how_many;
    protected $listeners = ['produkTemp'];


    public function produkTemp()
    {
          $this->refreshData();
    }
    public function mount() {
        $this->query = '';
        $this->type = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
        $this->list_product = Product::temp()->take($this->how_many)->get();
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->list_product = Product::temp()->take($this->how_many)->latest()->get();
    }

    public function render() {
        $this->refreshData();
        return view('livewire.buysback.buysback');
    }

    public function updatedQuery() {
        $this->search_results = Product::where('product_name', 'like', '%' . $this->query . '%')
            ->orWhere('product_code', 'like', '%' . $this->query . '%')
            ->take($this->how_many)->get();

    }

    public function loadMore() {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function clickQuery() {
        $this->refreshData();

    }

    public function selectProduct($product) {
        $this->emit('productSelected', $product);
         $this->resetQuery();
    }


    public function hapusItem($itemId)
    {
        $item = Product::find($itemId);
        if ($item) {
             $item->delete();
             $this->refreshData();
            // $this->emit('resetInput');
             $this->resetQuery();
        }
    }





}
