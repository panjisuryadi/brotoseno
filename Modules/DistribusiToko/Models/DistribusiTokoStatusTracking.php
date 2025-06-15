<?php

namespace Modules\DistribusiToko\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DistribusiTokoStatusTracking extends Pivot
{
    use HasFactory;

    protected $fillable = [];

    protected $casts = [
        "additional_information" => 'array'
    ];

    protected $table = 'distribusi_toko_tracking_statuses';
    
    protected static function newFactory()
    {
        return \Modules\DistribusiToko\Database\factories\DistribusiTokoStatusTrackingFactory::new();
    }

    public function pic(){
        return $this->belongsTo(User::class,'pic_id','id')->withoutGlobalScopes();
    }

    public function status(){
        return $this->belongsTo(DistribusiTokoStatus::class,'status_id','id');
    }
}
