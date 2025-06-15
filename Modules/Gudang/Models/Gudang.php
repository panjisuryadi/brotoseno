<?php

namespace Modules\Gudang\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gudang extends Model
{
    use HasFactory;
    protected $table = 'gudangs';
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
        return \Modules\Gudang\database\factories\GudangFactory::new();
    }
    public function baki() {
        return $this->hasMany(Baki::class, 'gudang_id', 'id');
    }

     public function product_item() {
        return $this->hasMany(ProductItem::class, 'gudang_id', 'id');
    }


}
