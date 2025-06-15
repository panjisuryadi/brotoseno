<?php

namespace Modules\PenjualanSale\Listeners\PenjualanSaleDetailCreated;

use Modules\PenjualanSale\Events\PenjualanSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Reports\Models\PiutangSalesReport;
use Modules\Stok\Models\StockSales;

class UpdateStockSales implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PenjualanSaleDetailCreated $event
     * @return void
     */
    public function handle(PenjualanSaleDetailCreated $event)
    {

        $penjualan_sale = $event->penjualan_sale;
        $penjualan_sale_detail = $event->penjualan_sale_detail;
        $penjualan_sale_payment = $event->penjualan_sale_payment;

        $stock_sales = StockSales::where([
            'sales_id' => $penjualan_sale->sales_id,
            'karat_id' => $penjualan_sale_detail->karat_id
        ])->first();

        $existingWeight = $stock_sales->weight;
        $stock_sales->update([
            'weight' => $existingWeight - $penjualan_sale_detail->weight
        ]);

        // if(!is_null($penjualan_sale_payment->lunas)){
        //     $latest = PiutangSalesReport::where(['karat_id'=>$penjualan_sale_detail->karat_id,'sales_id'=>$penjualan_sale->sales_id])->whereNotNull('weight_out')->latest()->first();
            
        //     PiutangSalesReport::create([
        //         'date' => $penjualan_sale->date,
        //         'karat_id' => $penjualan_sale_detail->karat_id,
        //         'sales_id' => $penjualan_sale->sales_id,
        //         'description' => 'Penjualan Sales oleh ' . $penjualan_sale->sales->name,
        //         'weight_out' => $penjualan_sale_detail->weight,
        //         'remaining_weight' => $latest->remaining_weight?($latest->remaining_weight - $penjualan_sale_detail->weight):$stock_sales->weight
        //     ]);
        // }

        if(!is_null($penjualan_sale_payment->lunas)){
            PiutangSalesReport::create([
                'date' => $penjualan_sale->date,
                'karat_id' => $penjualan_sale_detail->karat_id,
                'sales_id' => $penjualan_sale->sales_id,
                'description' => 'Penjualan Sales oleh ' . $penjualan_sale->sales->name,
                'weight_out' => $penjualan_sale_detail->weight,
                'remaining_weight' => $stock_sales->weight
            ]);
        }
    }
}
