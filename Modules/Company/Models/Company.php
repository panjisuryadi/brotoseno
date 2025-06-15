<?php

namespace Modules\Company\Models;
use Carbon\Carbon;
use app\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $guarded = [];



    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Company\database\factories\CompanyFactory::new();
    }


}
