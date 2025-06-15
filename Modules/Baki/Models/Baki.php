<?php

namespace Modules\Baki\Models;
use Modules\Gudang\Models\Gudang;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Baki extends Model
{
    use HasFactory;
    protected $table = 'bakis';
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
        return \Modules\Baki\database\factories\BakiFactory::new();
    }
  public function product_item() {
        return $this->hasMany(ProductItem::class, 'baki_id', 'id');
    }
   public function gudang() {
        return $this->belongsTo(Gudang::class, 'gudang_id', 'id');
    }

}
