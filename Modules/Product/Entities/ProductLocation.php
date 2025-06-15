<?php

namespace Modules\Product\Entities;

use Modules\Locations\Entities\Locations;
use Modules\Product\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function location()
    {
        return $this->belongsTo(Locations::class, 'location_id');
    }

    public function main()
    {
        return $this->hasMany(Locations::class, 'id', 'location_id');
    }
}
