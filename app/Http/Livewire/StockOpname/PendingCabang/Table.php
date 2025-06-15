<?php

namespace App\Http\Livewire\StockOpname\PendingCabang;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Adjustment\Entities\AdjustmentSetting;

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

    public function render()
    {
        $data = $this->model::with('karat');
        $data = $data->paginate(5);
        $this->emit('userStore');
        return view('livewire.stock-opname.pending-cabang.table', [
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
