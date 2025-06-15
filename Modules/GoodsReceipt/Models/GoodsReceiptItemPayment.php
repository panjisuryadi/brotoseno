<?php

namespace Modules\GoodsReceipt\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsReceiptItemPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'goodsreceipt_toko_item_payment';
    
    protected static function newFactory()
    {
        return \Modules\GoodsReceipt\Database\factories\GoodsReceiptItemPaymentFactory::new();
    }

}
