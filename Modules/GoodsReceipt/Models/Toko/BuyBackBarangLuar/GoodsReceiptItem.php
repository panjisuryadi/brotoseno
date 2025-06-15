<?php

namespace Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Cabang\Models\Cabang;
use Modules\GoodsReceipt\Models\GoodsReceiptItemPayment;
use Modules\Karat\Models\Karat;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockPending;

class GoodsReceiptItem extends Model
{

    protected $fillable = [
        'product_id',
        'cabang_id',
        'customer_id',
        'pic_id',
        'nominal',
        'note',
        'date',
        'type',
        'customer',
        'goodsreceipt_toko_nota_id'
    ];
    protected $table = 'goodsreceipt_toko_items';

    const APPROVED = 1;
    const REJECTED = 2;

    public function product(){
        return $this->belongsTo(Product::class)->withoutGlobalScope('filter_by_cabang');
    }

    public function scopePending($query){
        $query->whereHas('product', function ($query) {
            $query->where('status_id', ProductStatus::PENDING_CABANG);
        });
        if(auth()->user()->isUserCabang()){
            $query->where('cabang_id',auth()->user()->namacabang()->id);
        }
    }

    public function member_customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function getTypeLabelAttribute(){
        return match($this->type){
            1 => 'barang buyback',
            2 => 'barang luar'
        };
    }

    public function getCustomerNameAttribute(){
        if(is_null($this->customer_id)){
            return $this->customer;
        }
        return $this->member_customer->customer_name;
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status_id', self::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status_id', self::REJECTED);
    }

    public function approve(){
        $this->status_id = self::APPROVED;
        $this->save();
    }

    public function reject(){
        $this->status_id = self::REJECTED;
        $this->save();
    }

    public function payments(){
        return $this->hasMany(GoodsReceiptItemPayment::class, 'goodsreceipt_toko_item_id');
    }

}
