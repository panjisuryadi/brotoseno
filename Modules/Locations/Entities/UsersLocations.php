<?php

namespace Modules\Locations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Locations\Entities\Locations;
use App\Models\User;

class UsersLocations extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [];
    protected $with = ['locations','sublocations','users'];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function locations() {
        return $this->belongsTo(Locations::class, 'id_location', 'id');
    }
    public function sublocations() {
        return $this->belongsTo(Locations::class, 'sub_location', 'id');
    }
}

