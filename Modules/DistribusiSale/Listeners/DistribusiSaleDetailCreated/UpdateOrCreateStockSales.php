<?php

namespace Modules\DistribusiSale\Listeners\DistribusiSaleDetailCreated;

use Modules\DistribusiSale\Events\DistribusiSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Reports\Models\PiutangSalesReport;
use Modules\Stok\Models\StockSales;

class UpdateOrCreateStockSales implements ShouldQueue
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
     * @param DistribusiSaleDetailCreated $event
     * @return void
     */
    public function handle(DistribusiSaleDetailCreated $event)
    {
        $dist_sale = $event->dist_sale;
        $dist_sale_detail = $event->dist_sale_detail;

        $existingWeight = StockSales::where(['sales_id' => $dist_sale->sales_id, 'karat_id' => $dist_sale_detail->karat_id])->value('weight');

        $stock_sales = StockSales::updateOrCreate(
            ['sales_id'=>$dist_sale->sales_id,'karat_id'=>$dist_sale_detail->karat_id],
            ['weight'=>$dist_sale_detail->berat_bersih + $existingWeight]
        );

        PiutangSalesReport::create([
            'date' => $dist_sale->date,
            'karat_id' => $stock_sales->karat_id,
            'sales_id' => $dist_sale->sales_id,
            'description' => 'Distribusi Sales ke ' . $dist_sale->sales->name,
            'weight_in' => $dist_sale_detail->berat_bersih,
            'remaining_weight' => $stock_sales->weight
        ]);
    }
}
