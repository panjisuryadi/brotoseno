<?php

namespace Modules\PenerimaanBarangDP\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Cabang\Models\Cabang;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Product;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

//use Modules\JenisGroup\Models\JenisGroup;
class PenerimaanBarangDP extends Model implements HasMedia
{
  use HasFactory, InteractsWithMedia;
  protected $table = 'penerimaanbarangdps';
  // protected $fillable = [
  //     'name',
  //    // 'image',
  //    // 'code',
  //     'description',
  //     'start_date',
  //     'end_date',

  //  ];
  protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

  //   public function kategoriProduk() {
  //       return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
  //   }

  protected static function booted()
  {
    parent::booted();
    static::creating(function (PenerimaanBarangDP $penerimaanBarangDP) {
      $penerimaanBarangDP->no_barang_dp = self::generateInvoice();
      if (auth()->check() && auth()->user()->isUserCabang() && empty($penerimaanBarangDP->cabang_id)) {
        $penerimaanBarangDP->cabang_id = auth()->user()->namacabang()->id;
      }
    });

    if(auth()->check() && auth()->user()->isUserCabang()){
      self::addGlobalScope(function(Builder $builder) {
        $builder->where('cabang_id', auth()->user()->namacabang()->id);
      });
    }
  }
  protected static function newFactory()
  {
    return \Modules\PenerimaanBarangDP\database\factories\PenerimaanBarangDPFactory::new();
  }

  public function payment()
  {
    return $this->hasOne(PenerimaanBarangDPPayment::class, 'penerimaan_barang_dp_id', 'id');
  }

  public function karat()
  {
    return $this->belongsTo(Karat::class);
  }

  public function cabang()
  {
    return $this->belongsTo(Cabang::class);
  }

  private static function generateInvoice()
  {
    $lastString = self::orderBy('id', 'desc')->value('no_barang_dp');

    $numericPart = (int) substr($lastString, 3);
    $incrementedNumericPart = $numericPart + 1;
    $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
    $nextString = "DP-" . $nextNumericPart;
    return $nextString;
  }

  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }

  public function pic(): BelongsTo
  {
    return $this->belongsTo(User::class,'pic_id','id')->withoutGlobalScopes();
  }
}
