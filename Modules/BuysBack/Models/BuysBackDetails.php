<?php

namespace Modules\BuysBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
class BuysBackDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['product'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function buysback() {
        return $this->belongsTo(BuysBack::class, 'purchase_id', 'id');
    }

     public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function getPriceAttribute($value) {
        return $value / 100;
    }

    public function getUnitPriceAttribute($value) {
        return $value / 100;
    }

    public function getSubTotalAttribute($value) {
        return $value / 100;
    }

    public function getProductDiscountAmountAttribute($value) {
        return $value / 100;
    }

    public function getProductTaxAmountAttribute($value) {
        return $value / 100;
    }

    protected static function newFactory()
    {
        return \Modules\BuysBack\Database\factories\BuysBackDetailsFactory::new();
    }
}
