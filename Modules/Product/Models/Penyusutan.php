<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyusutan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'product_history_penyusutan';
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\PenyusutanFactory::new();
    }
}
