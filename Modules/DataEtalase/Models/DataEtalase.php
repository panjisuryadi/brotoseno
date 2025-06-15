<?php

namespace Modules\DataEtalase\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class DataEtalase extends Model
{
    use HasFactory;
    protected $table = 'dataetalases';
    protected $guarded = [];


  public function product_item() {
        return $this->hasMany(ProductItem::class, 'etalase_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\DataEtalase\database\factories\DataEtalaseFactory::new();
    }


}
