<?php

namespace Modules\ReturSale\Listeners\ReturSaleDetailCreated;

use Modules\ReturSale\Events\ReturSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
     * @param ReturSaleDetailCreated $event
     * @return void
     */
    public function handle(ReturSaleDetailCreated $event)
    {
        $retur_sale = $event->retur_sale;
        $retur_sale_detail = $event->retur_sale_detail;
        $stock_sales = StockSales::where([
            'sales_id' => $event->retur_sale->sales_id,
            'karat_id' => $event->retur_sale_detail->karat_id
        ])->first();

        $existingWeight = $stock_sales->weight;
        $stock_sales->update([
            'weight' => $existingWeight - $event->retur_sale_detail->weight
        ]);

        PiutangSalesReport::create([
            'date' => $retur_sale->date,
            'karat_id' => $retur_sale_detail->karat_id,
            'sales_id' => $retur_sale->sales_id,
            'description' => 'Retur Sales dari ' . $retur_sale->sales->name,
            'weight_out' => $retur_sale_detail->weight,
            'remaining_weight' => $stock_sales->weight
        ]);
    }
}
