<?php

namespace Modules\GoodsReceipt\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\StockKroom;

class GoodsReceiptInstallment extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang_cicilan';

    protected $fillable = [
        'payment_id',
        'nomor_cicilan',
        'tanggal_cicilan',
        'jumlah_cicilan',
        'nominal',
    ];
    
    protected static function newFactory()
    {
        return \Modules\GoodsReceipt\Database\factories\GoodsReceiptInstallmentFactory::new();
    }

    public function pembelian(){
        return $this->belongsTo(TipePembelian::class, 'payment_id');
    }

    public function stock_kroom()
    {
        return $this->morphToMany(StockKroom::class, 'transaction','stock_kroom_history','transaction_id','stock_kroom_id','id','id')->withTimestamps();
    }

}
