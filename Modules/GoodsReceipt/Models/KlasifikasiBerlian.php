<?php

namespace Modules\GoodsReceipt\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlasifikasiBerlian extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'klasifikasi_berlian';
    
    protected static function newFactory()
    {
        return \Modules\GoodsReceipt\Database\factories\KlasifikasiBerlianFactory::new();
    }
}
