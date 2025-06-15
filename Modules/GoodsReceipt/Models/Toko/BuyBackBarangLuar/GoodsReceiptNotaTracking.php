<?php

namespace Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;

use App\Models\TrackingStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Cabang\Models\Cabang;

class GoodsReceiptNotaTracking extends Pivot
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'goodsreceipt_toko_nota_tracking';
    
    public function pic(){
        return $this->belongsTo(User::class,'pic_id','id')->withoutGlobalScopes();
    }

    public function status(){
        return $this->belongsTo(TrackingStatus::class,'status_id','id');
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }
}
