<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Locations\Entities\AdjustedLocations;
use Modules\Locations\Entities\Locations;
use Modules\Stok\Models\StockOffice;

class AdjustmentLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'adjustment_location';

    public function getDescriptiveLocationTypeAttribute(){
        return match($this->attributes['location_type']){
            'Modules\Stok\Models\StockOffice' => 'Stock Gudang (Office)',
            'Modules\Stok\Models\StockSales' => 'Stock Sales (Office)',
            'Modules\Stok\Models\StockPendingOffice' => 'Stock Pending (Office)',
            'Modules\Stok\Models\StockKroom' => 'Stock Kroom (Office)',
            'Modules\Stok\Models\StokDp' => 'Stock DP (Cabang)',
        };
    }


}
