<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Karat\Models\Karat;

class StockPendingOffice extends Model
{
    use HasFactory;

    protected $fillable = [
        'karat_id',
        'weight'
    ];

    protected $table = 'stock_pending_office';
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\StockPendingOfficeFactory::new();
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }

    public function adjustments()
    {
        return $this->morphToMany(Adjustment::class, 'location','adjustment_location','location_id','adjustment_id','id','id');
    }
}
