<?php

namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;
use Modules\People\Entities\Customer;
//use Modules\JenisGroup\Models\JenisGroup;
class StokDp extends Model
{

    protected $table = 'stock_dp';
   
    protected $guarded = [];

     public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 

     public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function adjustments()
    {
        return $this->morphToMany(Adjustment::class, 'location','adjustment_location','location_id','adjustment_id','id','id');
    }



}
