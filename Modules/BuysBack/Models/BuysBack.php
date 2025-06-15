<?php

namespace Modules\BuysBack\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;
use Modules\JenisBuyBack\Models\JenisBuyBack;
use Modules\Karat\Models\Karat;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Status\Models\ProsesStatus;

class BuysBack extends Model
{
    use HasFactory;
    protected $table = 'buysbacks';
    protected $guarded = [];

  public function detail() {
        return $this->hasMany(BuysBackDetails::class, 'purchase_id', 'id');
    }

 public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function jenis() {
        return $this->belongsTo(JenisBuyBack::class, 'jenis_buyback_id', 'id');
    }



    public static function boot() {
        parent::boot();

        
    }

    public function scopeCompleted($query) {
        return $query->where('status', 'Completed');
    }

    public function getShippingAmountAttribute($value) {
        return $value / 100;
    }

    public function getPaidAmountAttribute($value) {
        return $value / 100;
    }

    public function getTotalAmountAttribute($value) {
        return $value / 100;
    }

    public function getDueAmountAttribute($value) {
        return $value / 100;
    }

    public function getTaxAmountAttribute($value) {
        return $value / 100;
    }

    public function getDiscountAmountAttribute($value) {
        return $value / 100;
    }























    protected static function newFactory()
    {
        return \Modules\BuysBack\database\factories\BuysBackFactory::new();
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function karat(){
        return $this->belongsTo(Karat::class);    
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }


    public function statuses(){
        return $this->belongsToMany(ProsesStatus::class,'buyback_statuses','buyback_id','status_id')->withTimestamps();
    }

    public function current_status(){
        return $this->belongsTo(ProsesStatus::class, 'status_id');
    }
}
