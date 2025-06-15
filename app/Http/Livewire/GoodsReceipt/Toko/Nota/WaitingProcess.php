<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\Nota;

use App\Models\LookUp;
use App\Models\TrackingStatus;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\BuysBack\Models\BuyBackNota;
use Modules\BuysBack\Models\BuyBackNotaStatus;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockCabang;

use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;
use Modules\Product\Models\ProductStatus;

class WaitingProcess extends Component
{
    public $nota;

    public $nota_items;

    public function render()
    {
        return view("livewire.goods-receipt.toko.nota.waiting-process");
    }

    public function nominalText($value){
        return 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }


    public function mount()
    {
        $this->nota_items = $this->nota->items;
    }

}
