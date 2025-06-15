<?php

namespace Modules\JenisGroup\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisGroup extends Model
{
    use HasFactory;
    protected $table = 'jenisgroups';
    // protected $fillable = [
    //     'name',

    //  ];
    protected $guarded = [];

     public function group() {
        return $this->hasMany(Group::class, 'jenis_group_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\JenisGroup\database\factories\JenisGroupFactory::new();
    }


}
