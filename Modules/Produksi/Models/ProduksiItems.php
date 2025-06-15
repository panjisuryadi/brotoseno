<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\KaratBerlian\Models\ShapeBerlian;

class ProduksiItems extends Model
{
    use HasFactory;

    protected $table = 'produksi_items';

    protected $fillable = ['produksis_id','karatberlians', 'qty', 'keterangan','model_id', 'karat_id', 'berat', 'goodsreceipt_id', 'kategoriproduk_id'];
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\ProduksiItemsFactory::new();
    }

    public function shape(){
        return $this->hasOne(ShapeBerlian::class, 'id', 'shapeberlian_id');
    }

    public function model()
    {
        return $this->hasOne(Group::class, 'id', 'model_id');
    }

    public function karat()
    {
        return $this->hasOne(Karat::class, 'id', 'karat_id');
    }
}
