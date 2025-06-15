<?php

namespace Modules\Locations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Locations\Entities\Locations;
class AdjustedLocations extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];
    protected $with = ['locations','sublocations','product'];

    public function adjustment() {
        return $this->belongsTo(Adjustment::class, 'adjustment_id', 'id');
    }
 public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function locations() {
        return $this->belongsTo(Locations::class, 'id_location', 'id');
    }
    public function sublocations() {
        return $this->belongsTo(Locations::class, 'sub_location', 'id');
    }
}

