<?php

namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Karat\Models\Karat;
//use Modules\JenisGroup\Models\JenisGroup;
class StockKroom extends Model
{

    protected $table = 'stock_kroom';

    protected $guarded = [];

   public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 


    public function adjustments()
    {
        return $this->morphToMany(Adjustment::class, 'location','adjustment_location','location_id','adjustment_id','id','id');
    }

 
    public function history(){
        return $this->hasMany(StockKroomHistory::class,'stock_kroom_id');
    }

    public function penerimaan_lantakan(){
        return $this->morphedByMany(PenerimaanLantakan::class, 'transaction', 'stock_kroom_history','stock_kroom_id','transaction_id','id','id')->withTimestamps();
    }

}
