<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;
use Modules\Karat\Models\Karat;
use Modules\Product\Models\ProductStatus;

class AssetReports extends Model
{
    use HasFactory;

    protected $table = 'assets_report';

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Reports\Database\factories\AssetReportsFactory::new();
    }

    public function current_status(){
        return $this->belongsTo(ProductStatus::class,'status_id');
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }

    public function karat(){
     return $this->belongsTo(Karat::class,'karat_id');
    }
}
