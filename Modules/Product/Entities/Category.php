<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KategoriProduk\Models\KategoriProduk;
class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function kategoriproduk() {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
    }

}
