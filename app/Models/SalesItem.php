<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'product',
        'name',
        'desc',
        'diskon',
        'ongkos',
        'total',
        'nomor',
        'sales_gold_id',
    ];
}
