<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DiamondCertificate\Models\DiamondCertificate;
use Modules\Karat\Models\Karat;
use Modules\People\Entities\Supplier;

class ProductItem extends Model
{
    use HasFactory;

    //protected $fillable = [];
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductItemFactory::new();
    }

     public function products() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

   public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

   public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }


   public function model() {
        return $this->belongsTo(DataEtalase::class, 'model_id', 'id');
    }


    public function certificates() {
        return $this->belongsTo(DiamondCertificate::class, 'certificate_id', 'id');
    }









}
