<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BuyBackSale\Models\BuyBackSale;
use Modules\Karat\Models\Karat;

class StockRongsok extends Model
{
    use HasFactory;

    protected $fillable = [
        'karat_id',
        'weight'
    ];

    protected $table = 'stock_rongsok';
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\StockRongsokFactory::new();
    }

    public function history(){
        return $this->hasMany(StockRongsokHistory::class,'stock_rongsok_id');
    }

    public function buyback_sales()
    {
        return $this->morphedByMany(BuyBackSale::class, 'transaction', 'stock_rongsok_history','stock_rongsok_id','transaction_id','id','id')->withTimestamps();
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }
}
