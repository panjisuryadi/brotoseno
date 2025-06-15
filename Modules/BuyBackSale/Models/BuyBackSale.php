<?php

namespace Modules\BuyBackSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CustomerSales\Entities\CustomerSales;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockRongsok;

//use Modules\JenisGroup\Models\JenisGroup;
class BuyBackSale extends Model
{
    use HasFactory;
    protected $table = 'buybacksales';
    // protected $fillable = [
    //     'name',
    //    // 'image',
    //    // 'code',
    //     'description',
    //     'start_date',
    //     'end_date',

    //  ];
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

  //   public function kategoriProduk() {
  //       return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
  //   }

    protected static function newFactory()
    {
        return \Modules\BuyBackSale\database\factories\BuyBackSaleFactory::new();
    }

    public function customerSale(){
      return $this->belongsTo(CustomerSales::class, 'customer_sales_id','id');
    }

    public function karat(){
      return $this->belongsTo(Karat::class,'karat_id','id');
    }

    public function sales(){
      return $this->belongsTo(DataSale::class,'sales_id','id');
    }

    public function stock_rongsok()
    {
        return $this->morphToMany(StockRongsok::class, 'transaction','stock_rongsok_history','transaction_id','stock_rongsok_id','id','id')->withTimestamps();
    }


}
