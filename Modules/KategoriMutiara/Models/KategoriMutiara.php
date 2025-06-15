<?php

namespace Modules\KategoriMutiara\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\JenisMutiara\Models\JenisMutiara;
class KategoriMutiara extends Model
{
    use HasFactory;
    protected $table = 'kategorimutiaras';
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

    public function jenismutiara() {
        return $this->belongsTo(JenisMutiara::class, 'jenis_mutiara_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\KategoriMutiara\database\factories\KategoriMutiaraFactory::new();
    }


}
