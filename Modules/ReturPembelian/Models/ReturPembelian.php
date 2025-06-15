<?php

namespace Modules\ReturPembelian\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Supplier;

//use Modules\JenisGroup\Models\JenisGroup;
class ReturPembelian extends Model
{
    use HasFactory;
    protected $table = 'returpembelians';
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\ReturPembelian\database\factories\ReturPembelianFactory::new();
    }


    public static function generateCode()
    {
        $date = now()->format('dmy');
        $code = 'RTRPB#';
        $dateCode = $code . $date;
        $lastOrder = self::select([DB::raw('MAX(returpembelians.retur_no) AS last_code')])
            ->where('retur_no', 'like', $dateCode . '%')
            ->first();
        $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
        $orderCode = $dateCode . '001';
        if ($lastOrderCode) {
            $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
            $nextOrderNumber = sprintf('%03d', (int)$lastOrderNumber + 1);
            $orderCode = $dateCode . $nextOrderNumber;
        }
        return $orderCode;
    }

    public function detail() {
        return $this->hasMany(ReturPembeliansDetail::class, 'retur_pembelian_id', 'id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

}
