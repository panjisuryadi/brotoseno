<?php

namespace Modules\DistribusiToko\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Product;
use Modules\Stok\Models\StockCabang;
use Modules\Stok\Models\StockOffice;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DistribusiTokoItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    protected $table = 'dist_toko_items';
    protected static function newFactory()
    {
        return \Modules\DistribusiToko\Database\factories\DistribusiTokoItemFactory::new();
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }

    public function stock_office()
    {
        return $this->morphToMany(StockOffice::class, 'transaction','stock_office_history','transaction_id','stock_office_id','id','id')->withTimestamps();
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function approved(){
        $this->status_id = 1;
        $this->save();
    }

    public function returned(){
        $this->status_id = 2;
        $this->save();
    }

    public function scopeApproved($query)
    {
        return $query->where('status_id', 1);
    }

    public function scopeReturned($query)
    {
        return $query->where('status_id', 2);
    }

    public function stock_cabang()
    {
        return $this->morphToMany(StockCabang::class, 'transaction','stock_cabang_history','transaction_id','stock_cabang_id','id','id')->withTimestamps();
    }

}
