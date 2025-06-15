<?php

namespace Modules\GoodsReceiptBerlian\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsReceiptQcAttribute extends Model
{
    use HasFactory;

    protected $table = 'goodsreceiptqcattribute';
    protected $fillable = [
        'goodsreceipt_id',
        'attributesqc_id',
        'keterangan',
        'note',
    ];

    public function qcAttribute(){
        return $this->hasOne(QcAttribute::class, 'id','attributesqc_id');
    }
    
    protected static function newFactory()
    {
        return \Modules\GoodsReceiptBerlian\Database\factories\GoodsReceiptQcAttributeFactory::new();
    }
}
