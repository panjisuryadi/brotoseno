<?php

namespace Modules\ItemColour\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemColour extends Model
{
    use HasFactory;
    protected $table = 'itemcolours';
    protected $fillable = [
        'name',
       // 'image',
        'value',
        'start_date',
        'end_date',

     ];

    protected static function newFactory()
    {
        return \Modules\ItemColour\database\factories\ItemColourFactory::new();
    }


}
