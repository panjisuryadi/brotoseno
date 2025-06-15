<?php

namespace Modules\DistribusiSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\DistribusiSale\Models\DistribusiSale;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockSales;

class DistribusiSaleDetail extends Model
{
    use HasFactory;
    protected $table = 'distribusi_sales_detail';

    protected $guarded = [];

    public function distribusi_sales() {
        return $this->belongsTo(DistribusiSale::class, 'distribusi_sales_id', 'id');
    } 

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\DistribusiSale\database\factories\DistribusiSaleFactory::new();
    }

    public function stock_office()
    {
        return $this->morphToMany(StockOffice::class, 'transaction','stock_office_history','transaction_id','stock_office_id','id','id')->withTimestamps();
    }

    public function stock_sales()
    {
        return $this->morphToMany(StockSales::class, 'transaction','stock_sales_history','transaction_id','stock_sales_id','id','id')->withTimestamps();
    }


}
