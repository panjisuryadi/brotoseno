<?php

namespace Modules\CustomerSales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\StokDp;
class CustomerSales extends Model
{

    use HasFactory;

    protected $guarded = [];

    protected static function newFactory() {
        return \Modules\CustomerSales\Database\factories\CustomerSalesFactory::new();
    }
}
