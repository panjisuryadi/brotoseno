<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomsCt extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customs_ct';
}
