<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockRongsokHistory extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'stock_rongsok_history';
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\StockRongsokHistoryFactory::new();
    }
}
