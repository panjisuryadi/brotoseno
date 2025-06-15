<?php

namespace Modules\KeluarMasuk\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;

//use Modules\JenisGroup\Models\JenisGroup;
class KeluarMasuk extends Model
{
    use HasFactory;
    protected $table = 'keluarmasuks';
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
        return \Modules\KeluarMasuk\database\factories\KeluarMasukFactory::new();
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }

}
