<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductTrackingHistory extends Pivot
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['properties'];

    protected $table = 'product_tracking_history';

    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductTrackingHistoryFactory::new();
    }
}
