<?php

namespace Modules\DistribusiSale\Listeners\DistribusiSaleDetailCreated;

use Modules\DistribusiSale\Events\DistribusiSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Stok\Models\StockOffice;

class UpdateStockOffice implements ShouldQueue
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
        $dist_sale_detail = $event->dist_sale_detail;

        $stock_office = StockOffice::where(['karat_id' => $dist_sale_detail->karat->parent->id])->first();
        $berat_real = $stock_office->berat_real;

        $stock_office->berat_real = $berat_real - $dist_sale_detail->berat_bersih;
        $stock_office->save();
    }
}
