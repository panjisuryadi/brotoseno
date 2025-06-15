<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Satuans extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'satuans_m';
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\SatuansFactory::new();
    }
}
