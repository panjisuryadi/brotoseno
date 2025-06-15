<?php

namespace Modules\Group\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\JenisGroup\Models\JenisGroup;
class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    // protected $fillable = [
    //     'end_date',

    //  ];
    protected $guarded = [];



     public function jenis_group() {
        return $this->belongsTo(JenisGroup::class, 'jenis_group_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Group\database\factories\GroupFactory::new();
    }


}
