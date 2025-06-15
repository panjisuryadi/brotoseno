<?php

namespace Modules\People\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function product_item() {
        return $this->hasMany(ProductItem::class, 'supplier_id', 'id');
    }
    protected static function newFactory() {
        return \Modules\People\Database\factories\SupplierFactory::new();
    }
}
