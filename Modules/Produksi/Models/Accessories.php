<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Accessories extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $table = 'accessories_m';

    const BERLIAN_TYPE = 1;
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\AccessoriesFactory::new();
    }

    public static function generateCodeBerlian()
    {
        return self::generateCode('BRL');
    }

    public static function generateCode($prefix = 'ACC')
    {
        $date = now()->format('dmY');
        $dateCode =  $prefix . $date;
        $lastOrder = self::select([DB::raw('MAX(accessories_m.code) AS last_code')])
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

    public function accessories_berlian()
    {
        return $this->belongsTo(AccessoriesBerlianDetail::class, 'id', 'accessories_id');
    }

    public function satuan()
    {
        return $this->hasone(Satuans::class, 'id', 'satuan_id');
    }
}
