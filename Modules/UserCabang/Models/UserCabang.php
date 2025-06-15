<?php

namespace Modules\UserCabang\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use app\Models\User;
use Modules\Cabang\Models\Cabang;
use Illuminate\Database\Eloquent\Relations\Pivot;
class UserCabang extends Pivot
{
    use HasFactory;
    protected $table = 'usercabangs';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\UserCabang\database\factories\UserCabangFactory::new();
    }


}
