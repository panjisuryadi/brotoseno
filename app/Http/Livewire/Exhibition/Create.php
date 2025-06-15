<?php

namespace App\Http\Livewire\Exhibition;

use Livewire\Component;
use Illuminate\Support\Collection;
use Modules\Product\Entities\Product;

class Create extends Component
{
    public $query;
    public $result;
    public $search;
    //public $search = [];
    public $type;
    public $search_results;
    public $list_product;
    public $how_many;
    public $listrfid = '';
    protected $listeners = ['produkTemp','reload','addRfid'];
    protected $queryString = ['search'];

    public function produkTemp()
    {
          $this->refreshData();
    }

    public function reload()
    {
          $this->resetForm();
    }
    public function mount() {
        $this->search = '';
        $this->query = '';
        $this->type = '';
        $this->how_many = 10;
        $this->search_results = Collection::empty();
        $this->list_product = Product::temp()->take($this->how_many)->get();
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->list_product = Product::take($this->how_many)->latest()->get();
    }

    public function render() {
        $this->refreshData();
        return view('livewire.exhibition.create');
    }

    public function addRfid($value)
        {
           $this->listrfid = $value;
        }

    public function updatedQuery() {
        $this->search_results = Product::where('product_code',$this->query)->first();

    }

    public function loadMore() {
        $this->how_many += 10;
        $this->updatedQuery();
    }

    public function resetQuery() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function resetForm() {
        $this->search = '';
        $this->search_results = Collection::empty();
    }

    public function clickQueryBackup() {
         $this->emit('productSelected', $product);
         $this->resetForm();
    }
    //4814635386019703

      //572983278902945089029458
      public function clickQuery() {
             // $string = "572983278902945089029458";
              $length = 8;
              $cari = $this->search;
              $hasilcari = preg_replace('/\s+/', '', $cari);
              $result = $this->pisah($hasilcari, $length);
              $product = array();
              foreach ($result as $row)
                {
                 $product[] = Product::where('rfid',$row)->first();
                }
              $this->emit('addProduk', $product);
              $this->resetForm();
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
                    //$this->emit('resetInput');
                     $this->resetQuery();
                }
            }


            protected function pisah($string, $length)
            {
                $strlen = strlen($string);
                $result = [];
                for ($i = 0; $i < $strlen; $i += $length) {
                    $result[] = substr($string, $i, $length);
                }
                return $result;
            }


}
