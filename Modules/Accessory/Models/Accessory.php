<?php

namespace Modules\Accessory\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class Accessory extends Model
{
    use HasFactory;
    protected $table = 'accessories_m';
    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Accessory\database\factories\AccessoryFactory::new();
    }


}
