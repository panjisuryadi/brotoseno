<?php

namespace Modules\ReturSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\DataSale\Models\DataSale;

class ReturSale extends Model
{
   
    protected $table = 'retursales';
    protected $guarded = [];

    public function detail() {
        return $this->hasMany(ReturSaleDetail::class, 'retur_sales_id', 'id');
    }

    public function sales(){
        return $this->belongsTo(DataSale::class,'sales_id','id');
    }


 


}
