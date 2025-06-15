<?php

namespace Modules\Status\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BuysBack\Models\BuysBack;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;

class ProsesStatus extends Model
{
    use HasFactory;

    protected $table = 'proses_statuses';

    protected $fillable = [
        'name'
    ];

    const STATUS = [
        'PENDING' => 1,
        'PENDING_OFFICE' => 2,
        'CUCI' => 3,
        'MASAK' => 4,
        'RONGSOK' => 5,
        'SECOND' => 6
    ];
    
    protected static function newFactory()
    {
        return \Modules\Status\Database\factories\ProsesStatusFactory::new();
    }

    public function buybacks(){
        return $this->belongsToMany(BuysBack::class, 'buyback_statuses','status_id','buyback_id');
    }

    public function barangluar(){
        return $this->belongsToMany(PenerimaanBarangLuar::class, 'barangluar_statuses','status_id','barangluar_id');
    }
}
