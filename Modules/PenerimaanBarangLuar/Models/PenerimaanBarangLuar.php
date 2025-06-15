<?php

namespace Modules\PenerimaanBarangLuar\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;
//use Modules\JenisGroup\Models\JenisGroup;
use Modules\Karat\Models\Karat;
use Modules\Status\Models\ProsesStatus;

class PenerimaanBarangLuar extends Model
{
    use HasFactory;
    protected $table = 'penerimaanbarangluars';
    // protected $fillable = [
    //     'name',
    //    // 'image',
    //    // 'code',
    //     'description',
    //     'start_date',
    //     'end_date',

    //  ];
    protected $guarded = [];
    public const GRCODE = 'BL';


  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

  //   public function kategoriProduk() {
  //       return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
  //   }

    protected static function newFactory()
    {
        return \Modules\PenerimaanBarangLuar\database\factories\PenerimaanBarangLuarFactory::new();
    }
    public function karat(){
      return $this->belongsTo(Karat::class);    
    }

    public function cabang(){
      return $this->belongsTo(Cabang::class);
    }

    public static function generateCode()
    {
        $dateCode = self::GRCODE . '-';
        $lastOrder = self::select([\DB::raw('MAX(penerimaanbarangluars.no_barang_luar) AS last_code')])
            ->where('no_barang_luar', 'like', $dateCode . '%')
            ->first();
        $lastGrCode = !empty($lastOrder['last_code']) ? $lastOrder['last_code'] : null;
        $orderCode = $dateCode . '00001';
        if ($lastGrCode) {
            $lastOrderNumber = str_replace($dateCode, '', $lastGrCode);
            $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
            $orderCode = $dateCode . $nextOrderNumber;
        }

        return $orderCode;
    }

    public function statuses(){
      return $this->belongsToMany(ProsesStatus::class,'barangluar_statuses','barangluar_id','status_id')->withTimestamps();
    }

    public function current_status(){
        return $this->belongsTo(ProsesStatus::class, 'status_id');
    }


}
