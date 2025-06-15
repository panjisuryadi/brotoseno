<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product; 

class ProductHistories extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'status',
        'keterangan',
        'harga',
        'tanggal',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); // assuming 'user' is the foreign key in hargas table
    }

}
