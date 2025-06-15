<?php

namespace Modules\PenerimaanBarangDP\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class PenerimaanBarangDPPayment extends Model
{
    use HasFactory;
    protected $table = 'penerimaan_barang_dp_payment';
    protected $guarded = [];

  

    protected static function newFactory()
    {
        return \Modules\PenerimaanBarangDP\database\factories\PenerimaanBarangDPFactory::new();
    }

    public function penerimaan_barang_dp(){
      return $this->belongsTo(PenerimaanBarangDP::class,'penerimaan_barang_dp_id','id');
    }

    public function detail(){
        return $this->hasMany(PaymentDetail::class,'payment_id','id');
    }

    public function getLabelTypeAttribute(){
        return ($this->type === 1)?'Jatuh Tempo':'Cicil';
    }

}
