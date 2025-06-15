<?php

namespace Modules\ItemShape\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemShape extends Model
{
    use HasFactory;
    protected $table = 'itemshapes';
    protected $fillable = [
        'name',
       // 'image',
        'value',
        'description',
        'start_date',
        'end_date',

     ];

    protected static function newFactory()
    {
        return \Modules\ItemShape\database\factories\ItemShapeFactory::new();
    }


}
