<?php

namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;

class StockPending extends Model
{

    protected $table = 'stock_pending';
   
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 

     public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    public function buyback_item()
    {
        return $this->morphedByMany(BuyBackItem::class, 'transaction', 'stock_pending_history','stock_pending_id','transaction_id','id','id')->withTimestamps();
    }

    public function history(){
        return $this->hasMany(StockPendingHistory::class,'stock_pending_id');
    }




}
