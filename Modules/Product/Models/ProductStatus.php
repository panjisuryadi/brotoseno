<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class ProductStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $table = 'product_status';

    const READY = 1;
    const SOLD = 2;
    const PENDING_CABANG = 3;
    const PENDING_OFFICE = 4;
    const CUCI = 5;
    const MASAK = 6;
    const RONGSOK = 7;
    const REPARASI = 8;
    const SECOND = 9;
    const HILANG = 10;
    const DRAFT = 11;
    const OTW = 12;
    const READY_OFFICE = 13; // use this instead of new
    const NEW = 13;
    const DP = 14;
    const REMOVED = 15;


    public function products(){
        return $this->belongsToMany(Product::class,'product_tracking_history','status_id','product_id')->withTimestamps();
    }

    
    
}
