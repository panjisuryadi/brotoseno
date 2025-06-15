<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\ProductLocation;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Locations\Entities\Locations;


class ProductTable extends Component
{
    use WithPagination;

     protected $paginationTheme = 'bootstrap';
     protected $listeners = ['hapus'];
     public $orderColumn = "product_id";
     public $sortOrder = "asc";
     public $sortLink = '<i class="sorticon fa fa-caret-up"></i>';

     public $destination = 0;
     public $searchTerm = "";
     public $cariLokasi = "";
     public $mainlokasi = "";
     public $main = "";
     public $sub_location = 0;
     public $pilih = "";



     public function updated(){
          $this->resetPage();
     }


    public function mount(){
        $setting = AdjustmentSetting::first();
        $this->main = Locations::whereIn('id',json_decode($setting->location))
                            ->get();
    }


     public function sortOrder($columnName=""){
          $caretOrder = "up";
          if($this->sortOrder == 'asc'){
               $this->sortOrder = 'desc';
               $caretOrder = "down";
          }else{
               $this->sortOrder = 'asc';
               $caretOrder = "up";
          }
          $this->sortLink = '<i class="sorticon fa fa-caret-'.$caretOrder.'"></i>';
          $this->orderColumn = $columnName;

     }

     public function render(){
          $status = AdjustmentSetting::first();
          $products = ProductLocation::with('product')
          ->orderby($this->orderColumn,$this->sortOrder);
          if(!empty($this->searchTerm)){
                $products->whereHas('product', function ($query) {
                    $query->where('product_name','like',"%".$this->searchTerm."%")->orWhere('product_code','like',"%".$this->searchTerm."%");
                });
             }
         if(!empty($this->cariLokasi)){
                $products->orwhereHas('main', function ($query) {
                    $query->where('parent_id',$this->cariLokasi)->orWhere('id',$this->cariLokasi);
                });
            }

            if($status->status == 1){
                $id = json_decode($status->location);
                $products = $products->where('product_locations.stock','>',0)->where('last_opname','<',$status->period)->whereIn('product_locations.location_id',$id);
            }else{
                $products = $products->where('product_locations.stock','>',0);
            }
          $products = $products->paginate(10);

          $this->emit('userStore');
          return view('livewire.product-table', [
               'products' => $products,
          ]);

     }

        public function showCountChanged($value) {
            // $this->limit = $value;
            $this->resetPage();
        }

        public function selectProduct($produks) {
            $this->emit('productSelected', $produks);
            // $this->emit('getqty', 1);
            //$this->pilih = $produks['id_produk'];
        }

         public function getDestination($value) {
            $this->emit('destinationSelected', $value);

        } public function hapus($value) {
           $this->pilih = '';

        }

}
