<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Locations\Entities\Locations;
use Modules\Adjustment\Entities\StockTransfer;

class StockTransferDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transfer() {
        return $this->belongsTo(StockTransfer::class, 'stock_transfer_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
   
    public function origins() {
        return $this->belongsTo(Locations::class, 'origin', 'id');
    }

    public function destinations() {
        return $this->belongsTo(Locations::class, 'destination', 'id');
    }
}
