<?php

namespace Modules\Sale\Entities;
use Modules\Cabang\Models\Cabang;
use Modules\People\Entities\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Auth;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const SP_DP = 'dp';
    public const SP_PAID = 'paid';
    public const S_COMPLETED = 'completed';
    public const S_DP = 'dp';
    public const S_FAILED = 'failed';

    public function saleDetails() {
        return $this->hasMany(SaleDetails::class, 'sale_id', 'id');
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
   public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

     public function scopeAkses($query)
        {

            $users = Auth::user()->id;
             if ($users == 1) {
                return $query;
            }
          //  Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->id):''

    return $query->where('cabang_id', Auth::user()->namacabang()->id);
        }




    public function salePayments() {
        return $this->hasMany(SalePayment::class, 'sale_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = Sale::max('id') + 1;
            $model->reference = make_reference_id('SL', $number);
        });
    }

    public function scopeCompleted($query) {
        return $query->where('status', 'Completed');
    }

    public function getShippingAmountAttribute($value) {
        return $value / 100;
    }

    public function getPaidAmountAttribute($value) {
        return $value;
    }

    public function getTotalAmountAttribute($value) {
        return $value;
    }

    public function getDueAmountAttribute() {
        return $this->attributes['paid_amount'] - $this->attributes['total_amount'];
    }

    public function getTaxAmountAttribute($value) {
        return $value / 100;
    }

    // public function getDiscountAmountAttribute($value) {
    //     return $value / 100;
    // }

    public function getCustomerNameAttribute(){
        if(empty($this->attributes['customer_id'])){
            return "Non Member";
        }else{
            return $this->customer->customer_name;
        }
    }

    public function manual(){
        return $this->hasMany(SaleManual::class,'sale_id');
    }
}
