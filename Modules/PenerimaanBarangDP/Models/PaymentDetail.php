<?php

namespace Modules\PenerimaanBarangDP\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'barangdp_payment_detail';

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\PenerimaanBarangDP\Database\factories\PaymentDetailFactory::new();
    }

    protected static function booted(){
        parent::booted();
        static::creating(function(PaymentDetail $paymentDetail){
            $paymentDetail->order_number = self::where('payment_id', $paymentDetail->payment_id)->max('order_number') + 1;
        });
        static::updated(function(PaymentDetail $paymentDetail){
            $paymentDetail->load('payment.penerimaan_barang_dp');
            $payment = $paymentDetail->payment;
            $dp = $payment->penerimaan_barang_dp;
            if($dp->nominal === $payment->detail->sum('nominal')){
                $payment->is_lunas = true;
                $payment->save();
            }
            $dp->box_fee = $payment->detail->sum('box_fee');
            $dp->save();
        });
    }

    public function payment(){
        return $this->belongsTo(PenerimaanBarangDPPayment::class, 'payment_id','id');
    }

    public function pic(){
        return $this->belongsTo(User::class,'pic_id','id')->withoutGlobalScopes();
    }

    public function getTotalFeeAttribute(){
        return $this->nominal + $this->box_fee;
    }
}
