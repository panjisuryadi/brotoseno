<?php

namespace App\Http\Livewire\DistribusiToko;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Stok\Models\StockOffice;

class Completed extends Component
{
    public $dist_toko;

    public function render(){
        return view("livewire.distribusi-toko.completed");
    }

    public function mount(){
        
    }
   
    public function rules()
    {
        $rules = [];

        
        return $rules;
    }

    public function submit(){
        
    }

}
