<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\Stok\Models\StockKroom;

class TipePembelian extends Model
{

    protected $table = 'tipe_pembelian';
    protected $guarded = [];


    public function goodreceipt() {
        return $this->belongsTo(GoodsReceipt::class,'goodsreceipt_id', 'id');
    }

    public function isCicil(){
        return $this->tipe_pembayaran == 'cicil';
    }

    public function detailCicilan(){
        return $this->hasMany(GoodsReceiptInstallment::class,'payment_id','id');
    }

    public function getTotalPaidAttribute(){
        return $this->detailCicilan->sum('jumlah_cicilan');
    }

}
