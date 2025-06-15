<?php

namespace App\Http\Livewire\DistribusiToko\Cabang;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Stok\Models\StockCabang;

class Retur extends Component
{
    public $dist_toko;

    public $dist_toko_items;


    public function render()
    {
        return view("livewire.distribusi-toko.cabang.retur");
    }

    public function mount()
    {
        $this->dist_toko_items = $this->dist_toko->items;
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }
}
