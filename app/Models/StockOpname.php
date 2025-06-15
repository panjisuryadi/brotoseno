<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    protected $table = 'stock_opname';
    protected $fillable = [
        'status',
    ];

    public function stock_opname_baki()
    {
        return $this->belongsTo(StockOpnameBaki::class, 'id', 'stock_opname_id'); // assuming 'user' is the foreign key in hargas table
    }

    public function stock_opname_product()
    {
        return $this->belongsTo(StockOpnameProduct::class, 'id', 'stock_opname_id'); // assuming 'user' is the foreign key in hargas table
    }

    public function stock_opname_history()
    {
        return $this->belongsTo(StockOpnameHistories::class, 'id', 'stock_opname_id'); // assuming 'user' is the foreign key in hargas table
    }

    public static function check_opname()
    {
        $stock  = self::latest()->first();
        return $stock->status; // or StockOpname::latest()->get();
    }
}
