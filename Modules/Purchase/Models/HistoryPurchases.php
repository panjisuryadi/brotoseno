<?php

namespace Modules\Purchase\Models;

use Modules\Product\Entities\Product;
use Modules\Purchase\Entities\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryPurchases extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['product'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function purchase() {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

     public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    protected static function newFactory()
    {
        return \Modules\Purchase\Database\factories\HistoryPurchasesFactory::new();
    }
}
