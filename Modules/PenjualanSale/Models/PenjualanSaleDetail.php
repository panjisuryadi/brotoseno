<?php

namespace Modules\PenjualanSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\PenjualanSale\Models\PenjualanSale;
use Modules\Stok\Models\StockKroom;
use Modules\Stok\Models\StockRongsok;
use Modules\Stok\Models\StockSales;

class PenjualanSaleDetail extends Model
{
    use HasFactory;
   
    protected $guarded = [];

    protected $table = 'penjualan_sales_detail';

    public function penjualanSale() {
        return $this->belongsTo(PenjualanSale::class, 'penjualan_sales_id', 'id');
    }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\PenjualanSale\database\factories\PenjualanSaleFactory::new();
    }

    public function stock_sales()
    {
        return $this->morphToMany(StockSales::class, 'transaction','stock_sales_history','transaction_id','stock_sales_id','id','id')->withTimestamps();
    }

    public function stock_kroom()
    {
        return $this->morphToMany(StockKroom::class, 'transaction','stock_kroom_history','transaction_id','stock_kroom_id','id','id')->withTimestamps();
    }

    public function stock_rongsok()
    {
        return $this->morphToMany(StockRongsok::class, 'transaction','stock_rongsok_history','transaction_id','stock_rongsok_id','id','id')->withTimestamps();
    }
}
