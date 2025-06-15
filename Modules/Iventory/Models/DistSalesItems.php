<?php

namespace Modules\Iventory\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Iventory\Models\Iventory;
class DistSalesItems extends Model
{

    protected $table = 'dist_sales_items';
  
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

  //   public function kategoriProduk() {
  //       return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
  //   }



}
