<?php

namespace Modules\GoodsReceiptBerlian\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsReceiptQcItems extends Model
{
    use HasFactory;

    protected $table = 'goodsreceiptqcitems';
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\GoodsReceiptBerlian\Database\factories\GoodsReceiptQcItemsFactory::new();
    }
}
