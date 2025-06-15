<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product; 

class Buyback extends Model
{
    use HasFactory;
    protected $table = 'buyback';
    protected $fillable = [
        'nota',
        'product_id',
        'status',
        'harga',
        'payment',
        'kondisi',
        'tanggal',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); // assuming 'user' is the foreign key in hargas table
    }

}
