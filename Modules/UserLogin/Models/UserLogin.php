<?php

namespace Modules\UserLogin\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class UserLogin extends Model
{
    use HasFactory;
    protected $table = 'user_logins';

    //protected $guarded = [];
     protected $fillable = ['user_id', 'ip', 'os', 'browser', 'token', 'login_at', 'logout_at', 'location'];

        //protected $casts = ['location' => 'object'];

        protected $casts = [
            'location' => 'array',
        ];

    protected static function newFactory()
    {
        return \Modules\UserLogin\database\factories\UserLoginFactory::new();
    }


}
