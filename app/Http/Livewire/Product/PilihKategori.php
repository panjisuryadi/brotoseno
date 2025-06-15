<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Product\Entities\Category;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Product;

class PilihKategori extends Component
{

    public $selected = '';
    public $categories;
    public $category;
    public $showCount;
    public $produkModel;
    public $category_name;

    public $selectedOption = '';

    public function selectOption($value)
    {
        $this->selectedOption = $value;
        $this->emit('optionSelected', $value);
    }

    public function mount() {
        $this->category_name;
        $this->how_many = 10;
        $this->produkModel = ProdukModel::take($this->how_many)->get();

    }

    public function render() {
        return view('livewire.product.pilih-kategori');
    }

    public function updatedCategory($value) {
        $cat = Category::where('id', $value)->first();
        $category_name = $cat->category_name;
         $this->emit('selected', $value);

    }

    public function updatedShowCount() {
        $this->emitUp('showCount', $this->category);
    }
}
