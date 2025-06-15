<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\Karat\Models\Karat;

class StockCabang extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'stock_cabang';
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\StockCabangFactory::new();
    }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    public function history(){
        return $this->hasMany(StockCabangHistory::class,'stock_cabang_id');
    }

    public function distribusi_toko_item()
    {
        return $this->morphedByMany(DistribusiTokoItem::class, 'transaction', 'stock_cabang_history','stock_cabang_id','transaction_id','id','id')->withTimestamps();
    }
}
