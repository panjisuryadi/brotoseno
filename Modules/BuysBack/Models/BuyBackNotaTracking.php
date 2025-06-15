<?php

namespace Modules\BuysBack\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BuyBackNotaTracking extends Pivot
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'buyback_nota_tracking';
    
    public function pic(){
        return $this->belongsTo(User::class,'pic_id','id')->withoutGlobalScopes();
    }

    public function status(){
        return $this->belongsTo(BuyBackNotaStatus::class,'status_id','id');
    }
}
