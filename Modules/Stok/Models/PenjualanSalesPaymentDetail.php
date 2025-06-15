<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanSalesPaymentDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'penjualan_sales_payment_detail';
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\PenjualanSalesPaymentDetailFactory::new();
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
