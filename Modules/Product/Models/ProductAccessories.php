<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Produksi\Models\Accessories;
use Modules\Produksi\Models\AccessoriesBerlianDetail;

class ProductAccessories extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'product_accessories';
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductAccessoriesFactory::new();
    }

    public function berlian_details(){
        return $this->hasOne(AccessoriesBerlianDetail::class,'accessories_id');
    }

    public function accessories(){
        return $this->belongsTo(Accessories::class);
    }
}
