<?php

namespace App\Http\Livewire\DistribusiToko;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Stok\Models\StockOffice;

class Retur extends Component
{
    public $dist_toko;

    public $total_weight_per_karat = [];

    public function render(){
        return view("livewire.distribusi-toko.retur");
    }

    protected $listeners = [
        'is_approved' => 'handleIsApproved'
    ];

    public function mount(){
        
    }
   
    public function rules()
    {
        $rules = [];

        
        return $rules;
    }

    public function submit(){
        
    }

    public function handleIsApproved($is_approved){
        if($is_approved){
            foreach($this->dist_toko->items()->returned()->get() as $item){
                $item->product->updateTracking(ProductStatus::PENDING_OFFICE);
            }
            $this->dist_toko->setAsCompleted();
            toast('Berhasil Menambah Stok Gudang','success');
            return redirect(route('distribusitoko.emas'));
        }
    }

}
