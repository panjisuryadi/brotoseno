<?php

namespace Modules\Bandrol\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bandrol extends Model
{
    use HasFactory;
    protected $table = 'bandrols';
    // protected $fillable = [
    //     'name',
    //    // 'image',
    //    // 'code',
    //     'description',
    //     'start_date',
    //     'end_date',

    //  ];
    protected $guarded = [];
    protected static function newFactory()
    {
        return \Modules\Bandrol\database\factories\BandrolFactory::new();
    }


}
