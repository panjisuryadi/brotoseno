<?php

namespace Modules\PenjualanSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\CustomerSales\Entities\CustomerSales;
use Modules\PenjualanSale\Models\PenjualanSaleDetail;
use Modules\DataSale\Models\DataSale;
class PenjualanSale extends Model
{
    use HasFactory;
   
    protected $guarded = [];

    public function detail() {
        return $this->hasMany(PenjualanSaleDetail::class, 'penjualan_sales_id', 'id');
    }

    public function sales() {
        return $this->belongsTo(DataSale::class, 'sales_id', 'id');
    }

    public function payment(){
        return $this->hasOne(PenjualanSalesPayment::class,'penjualan_sales_id','id');
    }

    public function customer(){
        return $this->belongsTo(CustomerSales::class,'konsumen_sales_id', 'id');
    }


    protected static function newFactory()
    {
        return \Modules\PenjualanSale\database\factories\PenjualanSaleFactory::new();
    }

    public static function generateCode()
    {
        $date = now()->format('dmy');
        $invoice_code = 'PSL#';
        $dateCode = $invoice_code . $date;
        $lastOrder = self::select([DB::raw('MAX(penjualan_sales.invoice_no) AS last_code')])
            ->where('invoice_no', 'like', $dateCode . '%')
            ->first();
        $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
        $orderCode = $dateCode . '001';
        if ($lastOrderCode) {
            $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
            $nextOrderNumber = sprintf('%03d', (int)$lastOrderNumber + 1);
            $orderCode = $dateCode . $nextOrderNumber;
        }
        return $orderCode;
    }


}
