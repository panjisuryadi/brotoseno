<?php

namespace Modules\JenisBuyBack\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class JenisBuyBack extends Model
{
    use HasFactory;
    protected $table = 'jenisbuybacks';

    protected $guarded = [];
    public function buyback() {
        return $this->hasMany(BuysBack::class, 'jenis_buyback_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\JenisBuyBack\database\factories\JenisBuyBackFactory::new();
    }


}
