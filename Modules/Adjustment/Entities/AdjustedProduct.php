<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Locations\Entities\Locations;

class AdjustedProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['product'];

    public function adjustment() {
        return $this->belongsTo(Adjustment::class, 'adjustment_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
   
    public function location() {
        return $this->belongsTo(Locations::class, 'id_location', 'id');
    }
}
