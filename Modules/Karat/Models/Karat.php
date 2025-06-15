<?php

namespace Modules\Karat\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\StockOffice;
use Modules\PenentuanHarga\Models\PenentuanHarga;
use Modules\Stok\Models\StockSales;


class Karat extends Model
{
    use HasFactory;
    protected $table = 'karats';
    protected $fillable = [
        'parent_id',
        'name',
        'kode',
        'type',
        'coef',
        'margin',
        'diskon',
        'persen',
        'description',
        'start_date',
        'end_date',
        'harga'
     ];

    protected static function newFactory()
    {
        return \Modules\Karat\database\factories\KaratFactory::new();
    }

    public function stockOffice(){
        return $this->hasOne(StockOffice::class,'karat_id','id');
    }

    public function parent(){
        return $this->belongsTo(Karat::class,'parent_id','id');
    }


     public function harga(){
        return $this->hasOne(PenentuanHarga::class);
    }

    public function children(){
        return $this->hasMany(Karat::class, 'parent_id');
    }

  public function list_harga(){
        return $this->hasMany(PenentuanHarga::class,'karat_id','id');
    }

    public function penentuanHarga(){
        if(empty($this->parent_id)){
            return $this->hasOne(PenentuanHarga::class,'karat_id','id');
        }
        return $this->parent->penentuanHarga();
    }

    public function stockSales(){
        return $this->hasOne(StockSales::class, 'karat_id','id');
    }

    public static function logam_mulia(){
        return self::where('type','LM')->firstOrFail();
    }

    public function getLabelAttribute(){
        if(!empty($this->parent_id)){
            return $this->parent->label . ' ' . $this->name;
        }
        return $this->name . ' | ' . $this->kode;
    }

    public function scopeKarat($query){
        $query->where('parent_id',null);
    }

    public function getCoefAttribute($value){
        if(empty($this->parent_id)){
            return $value;
        }else{
            return $this->parent->coef;
        }
    }
}
