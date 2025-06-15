<?php

namespace Modules\ReturSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Karat\Models\Karat;
use Modules\ReturSale\Models\ReturSale;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockSales;

class ReturSaleDetail extends Model
{

    protected $table = 'retur_sales_detail';
    protected $guarded = [];


    public function retursales() {
        return $this->belongsTo(ReturSale::class, 'retur_sales_id', 'id');
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }

    public function stock_sales()
    {
        return $this->morphToMany(StockSales::class, 'transaction','stock_sales_history','transaction_id','stock_sales_id','id','id')->withTimestamps();
    }

    public function stock_office()
    {
        return $this->morphToMany(StockOffice::class, 'transaction','stock_office_history','transaction_id','stock_office_id','id','id')->withTimestamps();
    }

   


}
