<?php

namespace Modules\Locations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Locations\Entities\AdjustedLocations;
class Locations extends Model
{
    use HasFactory;
    protected $fillable = [];
    protected $guarded = [];
 protected $with = ['childs'];

    public function userslokasi() {
        return $this->hasMany(UsersLocations::class, 'id_location', 'id');
    }

   public function childs() {
        return $this->hasMany(Locations::class, 'parent_id');
    }
   
    public function parent() {
        return $this->belongsTo(Locations::class, 'parent_id');
    }



public function scopeByParent($query) {
        return $query->where('parent_id', null);
    }












}
