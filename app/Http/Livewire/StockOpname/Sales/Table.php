<?php

namespace App\Http\Livewire\StockOpname\Sales;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\ProductLocation;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\DataSale\Models\DataSale;
use Modules\Locations\Entities\Locations;

class Table extends Component
{
    use WithPagination;

     protected $paginationTheme = 'bootstrap';
     public $orderColumn = "karat_id";
     public $sortOrder = "asc";
     public $sortLink = '<i class="sorticon fa fa-caret-up"></i>';

     public $destination = 0;
     public $searchTerm = "";
     public $mainlokasi = "";
     public $sub_location = 0;
     public $pilih = "";

     public $model;

     public $active_location;

     public $sales_id;
     public $datasales;


     public function updated(){
          $this->resetPage();
     }


    public function mount(){
        $setting = AdjustmentSetting::first();
        $ids = $this->model::all()->pluck('id')->toArray();
        $this->datasales = DataSale::all();
        $this->sales_id = $this->datasales->first()->id;
    }


     public function render(){
        $data = $this->model::with('karat')->where('sales_id',$this->sales_id);
        $data = $data->paginate(5);
        $this->emit('userStore');
        return view('livewire.stock-opname.sales.table', [
            'products' => $data,
        ]);

     }

        public function showCountChanged($value) {
            // $this->limit = $value;
            $this->resetPage();
        }

        public function selectProduct($key) {
            $this->emit('showModal', ['modalId' => $key]);
        }

         public function getDestination($value) {
            $this->emit('destinationSelected', $value);

        } public function hapus($value) {
           $this->pilih = '';

        }

}
