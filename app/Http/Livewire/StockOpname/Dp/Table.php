<?php

namespace App\Http\Livewire\StockOpname\Dp;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Cabang\Models\Cabang;

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

     public $cabang_id;
     public $datacabang;


     public function updated(){
          $this->resetPage();
     }


    public function mount(){
        $setting = AdjustmentSetting::first();
        $ids = $this->model::all()->pluck('id')->toArray();
        $this->datacabang = Cabang::all();
        $this->cabang_id = $this->datacabang->first()->id;
    }


     public function render(){
        $data = $this->model::with('karat')->where('cabang_id',$this->cabang_id);
        $data = $data->paginate(5);
        $this->emit('userStore');
        return view('livewire.stock-opname.dp.table', [
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
