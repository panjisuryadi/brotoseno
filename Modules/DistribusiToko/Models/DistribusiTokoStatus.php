<?php

namespace Modules\DistribusiToko\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistribusiTokoStatus extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = "distribusi_toko_status";
    
    protected static function newFactory()
    {
        return \Modules\DistribusiToko\Database\factories\DistribusiTokoStatusFactory::new();
    }

    public function distribusi_toko(){
        return $this->belongsToMany(DistribusiToko::class, 'distribusi_toko_tracking_statuses','status_id','dist_toko_id');
    }
}
