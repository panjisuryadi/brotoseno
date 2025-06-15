<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Adjustment\Entities\StockTransferDetail;

class StockTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Adjustment\Database\factories\StockTransferFactory::new();
    }

    public function transferdetail() {
        return $this->hasMany(StockTransferDetail::class, 'stock_transfer_id', 'id');
    }   
}
