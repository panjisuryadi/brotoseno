<?php

namespace Modules\ItemRound\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemRound extends Model
{
    use HasFactory;
    protected $table = 'itemrounds';
    protected $fillable = [
        'name',
       // 'image',
        'description',
        'value',
        'start_date',
        'end_date',

     ];

    protected static function newFactory()
    {
        return \Modules\ItemRound\database\factories\ItemRoundFactory::new();
    }


}
