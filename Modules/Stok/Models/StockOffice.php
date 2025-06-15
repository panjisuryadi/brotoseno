<?php


namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Adjustment\Entities\Adjustment;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Product;

class StockOffice extends Model
{

    protected $table = 'stock_office';
   
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }


    public function adjustments()
    {
        return $this->morphToMany(Adjustment::class, 'location','adjustment_location','location_id','adjustment_id','id','id');
    }

    public function goods_receipt_item()
    {
        return $this->morphedByMany(GoodsReceiptItem::class, 'transaction', 'stock_office_history','stock_office_id','transaction_id','id','id')->withTimestamps();
    }

    public function distribusi_toko_item()
    {
        return $this->morphedByMany(DistribusiTokoItem::class, 'transaction', 'stock_office_history','stock_office_id','transaction_id','id','id')->withTimestamps();
    }

    public function product()
    {
        return $this->morphedByMany(Product::class, 'transaction', 'stock_office_history','stock_office_id','transaction_id','id','id')->withTimestamps();
    }

    public function history(){
        return $this->hasMany(StockOfficeHistory::class,'stock_office_id');
    }

    public function distribusi_sales_item()
    {
        return $this->morphedByMany(DistribusiSaleDetail::class, 'transaction', 'stock_office_history','stock_office_id','transaction_id','id','id')->withTimestamps();
    }


}
