<?php

namespace App\Http\Livewire\StockOpname\GudangOffice;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\ProductLocation;
use Modules\Adjustment\Entities\AdjustmentSetting;
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


     public function updated(){
          $this->resetPage();
     }


    public function mount(){
        $setting = AdjustmentSetting::first();
        $ids = $this->model::all()->pluck('id')->toArray();
    }


     public function render(){
        $data = $this->model::with('karat');
        $data = $data->paginate(5);
        $this->emit('userStore');
        return view('livewire.stock-opname.gudang-office.table', [
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
