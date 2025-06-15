<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOfficeHistory extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'stock_office_history';
}
