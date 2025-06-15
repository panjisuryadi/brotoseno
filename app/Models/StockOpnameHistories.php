<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product; 

class StockOpnameHistories extends Model
{
    use HasFactory;
    protected $table = 'stock_opname_histories';
    protected $fillable = [
        'stock_opname_id',
        'baki_id',
        'product_id',
        'status',
        'keterangan',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); // assuming 'user' is the foreign key in hargas table
    }

    public function baki()
    {
        return $this->belongsTo(Baki::class, 'baki_id', 'id'); // assuming 'user' is the foreign key in hargas table
    }
}
