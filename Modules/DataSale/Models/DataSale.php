<?php

namespace Modules\DataSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PenjualanSale\Models\PenjualanSale;
use Modules\Stok\Models\StockSales;

//use Modules\JenisGroup\Models\JenisGroup;
class DataSale extends Model
{
    use HasFactory;
    protected $table = 'datasales';
   
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

  //   public function kategoriProduk() {
  //       return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
  //   }

    protected static function newFactory()
    {
        return \Modules\DataSale\database\factories\DataSaleFactory::new();
    }

    public function insentif(){
      return $this->hasMany(Insentif::class,'sales_id','id');
    }

    public function penjualanSale(){
      return $this->hasMany(PenjualanSale::class,'sales_id','id');
    }

    public function stockSales(){
      return $this->hasMany(StockSales::class,'sales_id','id');
    }


}
