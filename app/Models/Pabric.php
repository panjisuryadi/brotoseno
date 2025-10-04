<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pabric extends Model
{
    use HasFactory;
    protected $table    = 'pabrics';
    protected $fillable = [
        'name',
        'status',
    ];
}
