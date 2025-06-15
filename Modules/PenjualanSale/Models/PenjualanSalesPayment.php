<?php

namespace Modules\PenjualanSale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\PenjualanSalesPaymentDetail;

class PenjualanSalesPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe_pembayaran',
        'lunas',
        'cicil',
        'jatuh_tempo'
    ];

    protected $table = 'penjualan_sales_payment';
    
    protected static function newFactory()
    {
        return \Modules\PenjualanSale\Database\factories\PenjualanSalesPaymentFactory::new();
    }

    public function penjualanSales(){
        return $this->belongsTo(PenjualanSale::class,'penjualan_sales_id','id');
    }

    public function detailCicilan() {
        return $this->hasMany(PenjualanSalesPaymentDetail::class, 'payment_id', 'id');
    }
}
