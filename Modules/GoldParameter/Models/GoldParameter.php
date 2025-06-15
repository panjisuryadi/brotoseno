<?php

namespace Modules\GoldParameter\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Group\Models\Group;
class GoldParameter extends Model
{
    use HasFactory;
    protected $table = 'goldparameters';
    // protected $fillable = [
    //     'name',
    //    // 'image',
    //    // 'code',
    //     'description',
    //     'start_date',
    //     'end_date',

    //  ];
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

    public function groups() {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\GoldParameter\database\factories\GoldParameterFactory::new();
    }


}
