<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookUp extends Model
{
    use HasFactory;

    protected $table = 'lookup_m'; //Lookup digunakan untuk membuat constant di database
    
}
