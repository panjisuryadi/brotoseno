<?php

namespace Modules\PenentuanHarga\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Modules\Karat\Models\Karat;
use Modules\PenentuanHarga\Models\PenentuanHarga;

class HistoryPenentuanHarga extends Model
{

    protected $table = 'history_penentuan_harga';
    protected $guarded = [];


    public function penentuan_harga() {
        return $this->belongsTo(PenentuanHarga::class, 'penentuan_harga_id', 'id');
    } 
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

 

  

}
