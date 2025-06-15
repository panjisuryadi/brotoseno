<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Modules\Product\Entities\Product;
use Modules\Locations\Entities\Locations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrackingProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

   public function products() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Locations::class, 'location_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\TrackingProductFactory::new();
    }
}
