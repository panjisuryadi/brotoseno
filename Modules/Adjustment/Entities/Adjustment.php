<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Cabang\Models\Cabang;
use Modules\Locations\Entities\AdjustedLocations;
use Modules\Locations\Entities\Locations;
use Modules\Stok\Models\StockKroom;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockPending;
use Modules\Stok\Models\StockPendingOffice;
use Modules\Stok\Models\StockSales;
use Modules\Stok\Models\StokDp;

class Adjustment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('d M, Y');
    }

    public function adjustedProducts() {
        return $this->hasMany(AdjustedProduct::class, 'adjustment_id', 'id');
    }

 public function adjustedLocations() {
        return $this->hasMany(AdjustedLocations::class, 'adjustment_id', 'id');
    }

    public function stockOffice()
    {
        return $this->morphedByMany(StockOffice::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public function products(){
        return $this->hasMany(AdjustmentLocation::class,'adjustment_id');
    }

    public function location(){
        return $this->hasOne(AdjustmentLocation::class, 'adjustment_id');
    }

    public function stockSales()
    {
        return $this->morphedByMany(StockSales::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public function stockPendingOffice(){
        return $this->morphedByMany(StockPendingOffice::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public function stockPendingCabang(){
        return $this->morphedByMany(StockPending::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public function stockKroom(){
        return $this->morphedByMany(StockKroom::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public function stockDP(){
        return $this->morphedByMany(StokDp::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public static function generateCode()
    {
        $date = now()->format('dmY');
        $code = 'ADJ';
        $dateCode = $code . $date;
        $lastOrder = self::select([DB::raw('MAX(adjustments.reference) AS last_code')])
            ->where('reference', 'like', $dateCode . '%')
            ->first();
        $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
        $orderCode = $dateCode . '00001';
        if ($lastOrderCode) {
            $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
            $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
            $orderCode = $dateCode . $nextOrderNumber;
        }

        return $orderCode;
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }


}
