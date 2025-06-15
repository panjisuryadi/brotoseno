<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SaleManual extends Model
{

    protected $table = 'sales_manual';

    protected $guarded = [];

    public function sale() {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

}
