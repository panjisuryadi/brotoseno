<?php

namespace Modules\ReturPembelian\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockOffice;

class ReturPembeliansDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'returpembelians_detail';
    
    protected static function newFactory()
    {
        return \Modules\ReturPembelian\Database\factories\ReturPembeliansDetailFactory::new();
    }


    public function stock_office()
    {
        return $this->morphToMany(StockOffice::class, 'transaction','stock_office_history','transaction_id','stock_office_id','id','id')->withTimestamps();
    }

    public function karat(){
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }
}
