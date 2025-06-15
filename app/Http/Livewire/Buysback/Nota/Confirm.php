<?php

namespace App\Http\Livewire\Buysback\Nota;

use App\Models\LookUp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Stok\Models\StockCabang;

class Confirm extends Component
{

    public $buyback_nota;

    public function render()
    {
        return view("livewire.buysback.nota.confirm");
    }

    public function mount()
    {

    }

    public function nominalText($value){
        return 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

    
}
