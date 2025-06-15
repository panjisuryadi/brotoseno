<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerimaanLantakan extends Model
{
    use HasFactory;

    protected $table = 'penerimaanlantakan';
    
    protected $fillable = [
        'karat_id', 'weight', 'additional_data'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\PenerimaanLantakanFactory::new();
    }

    public function stock_kroom()
    {
        return $this->morphToMany(StockKroom::class, 'transaction','stock_kroom_history','transaction_id','stock_kroom_id','id','id')->withTimestamps();
    }
}
