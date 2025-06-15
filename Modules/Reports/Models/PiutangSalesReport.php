<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;

class PiutangSalesReport extends Model
{
    use HasFactory;

    protected $table = 'piutang_sales_report';

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Reports\Database\factories\PiutangSalesReportFactory::new();
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }
}
