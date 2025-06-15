<?php

namespace Modules\KaratBerlian\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShapeBerlian extends Model
{
    use HasFactory;

    protected $table = 'shapeberlians';

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\KaratBerlian\Database\factories\ShapeBerlianFactory::new();
    }
}
