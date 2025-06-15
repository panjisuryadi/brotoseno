<?php

namespace Modules\Timbangan\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class Timbangan extends Model
{
    use HasFactory;
    protected $table = 'timbangans';
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
        return \Modules\Timbangan\database\factories\TimbanganFactory::new();
    }


}
