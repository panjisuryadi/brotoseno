<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameBaki extends Model
{
    use HasFactory;
    protected $table = 'stock_opname_baki';
    protected $fillable = [
        'stock_opname_id',
        'baki_id',
        'name',
        'code',
        'posisi',
        'used',
        'capacity',
        'status',
    ];
}
