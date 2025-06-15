<?php

namespace Modules\PenerimaanBarangLuar\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
class PenerimaanBarangLuarIncentive extends Model
{
    use HasFactory;
    protected $table = 'penerimaan_barang_luar_insentif';
    
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\PenerimaanBarangLuar\database\factories\PenerimaanBarangLuarFactory::new();
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }

    public function sales(){
        return $this->belongsTo(DataSale::class);
    }
}
