<?php

namespace Modules\People\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\StokDp;
class Customer extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected $table = "customers";

    protected static function newFactory() {
        return \Modules\People\Database\factories\CustomerFactory::new();
    }
      public function stokdp() {
        return $this->hasMany(StokDp::class, 'customer_id', 'id');
    }


}
