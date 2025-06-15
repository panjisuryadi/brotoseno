<?php

namespace Modules\Produksi\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\Stok\Models\StockKroom;

//use Modules\JenisGroup\Models\JenisGroup;
class Produksi extends Model
{
    use HasFactory;
    protected $table = 'produksis';
    protected $guarded = [];

    const PRDCODE = 'PRD';

    protected static function newFactory()
    {
        return \Modules\Produksi\database\factories\ProduksiFactory::new();
    }

    public function karatasal()
    {
        return $this->belongsTo(Karat::class, 'karatasal_id', 'id');
    }

    public function karatjadi()
    {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(Group::class, 'model_id', 'id');
    }

    public function produksi_items()
    {
        return $this->hasMany(ProduksiItems::class, 'produksis_id', 'id');
    }

    public static function generateCode()
    {
        $date = now()->format('dmY');
        $dateCode = self::PRDCODE . $date;
        $lastOrder = self::select([DB::raw('MAX(produksis.code) AS last_code')])
            ->where('code', 'like', $dateCode . '%')
            ->first();
        $lastGrCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
        $orderCode = $dateCode . '00001';
        if ($lastGrCode) {
            $lastOrderNumber = str_replace($dateCode, '', $lastGrCode);
            $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
            $orderCode = $dateCode . $nextOrderNumber;
        }

        return $orderCode;
    }

    public function stock_kroom()
    {
        return $this->morphToMany(StockKroom::class, 'transaction','stock_kroom_history','transaction_id','stock_kroom_id','id','id')->withTimestamps();
    }


}
