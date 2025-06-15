<?php

namespace Modules\KategoriProduk\Models;

use Carbon\Carbon;
use Modules\Product\Entities\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriProduk extends Model
{
    use HasFactory;
    protected $table = 'kategoriproduks';
    protected $fillable = [
        'name',
        'image',
        'slug',
        'description',
        'start_date',
        'end_date',

     ];


    protected static function newFactory()
    {
        return \Modules\KategoriProduk\database\factories\KategoriProdukFactory::new();
    }

     public function category() {
        return $this->hasMany(Category::class, 'kategori_produk_id', 'id');
    }



}
