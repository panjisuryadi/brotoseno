<?php

namespace Modules\GoodsReceiptBerlian\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QcAttribute extends Model
{
    use HasFactory;

    protected $table = 'qcattribute';

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\GoodsReceiptBerlian\Database\factories\QcAttributeFactory::new();
    }
}
