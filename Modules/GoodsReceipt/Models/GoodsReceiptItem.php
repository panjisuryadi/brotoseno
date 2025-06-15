<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\Karat\Models\Karat;
use Modules\KaratBerlian\Models\ShapeBerlian;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Produksi\Models\Accessories;
use Modules\Stok\Models\StockOffice;

class GoodsReceiptItem extends Model
{

    protected $table = 'goodsreceipt_items';
    protected $guarded = [];

    protected $with = ['karat'];


    public function goodsreceiptitem() {
        return $this->belongsTo(GoodsReceipt::class, 'goodsreceipt_id', 'id');
    }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 

     public function mainkategori() {
        return $this->belongsTo(KategoriProduk::class, 'kategoriproduk_id', 'id');
    }

    public function stock_office()
    {
        return $this->morphToMany(StockOffice::class, 'transaction','stock_office_history','transaction_id','stock_office_id','id','id')->withTimestamps();
    }

    public function shape_berlian()
    {
        return $this->belongsTo(ShapeBerlian::class, 'shapeberlian_id', 'id');
    }

    public function accessories()
    {
        return $this->hasOne(Accessories::class, 'id', 'accessories_id');
    }


}
