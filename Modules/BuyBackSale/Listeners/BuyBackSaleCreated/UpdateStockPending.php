<?php

namespace Modules\BuyBackSale\Listeners\BuyBackSaleCreated;

use Modules\BuyBackSale\Events\BuyBackSaleCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Stok\Models\StockPending;

class UpdateStockPending implements ShouldQueue
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
     * @param BuyBackSaleCreated $event
     * @return void
     */
    public function handle(BuyBackSaleCreated $event)
    {
        $data = $event->buyBackSale;
        $existingWeight = StockPending::where(
            [
                'sales_id' => $data->sales_id,
                'karat_id' => $data->karat_id,
                'type' => 'buyback'
            ],
        )->value('weight');

        StockPending::updateOrCreate(
            ['sales_id' => $data->sales_id,'karat_id'=>$data->karat_id,'type'=>'buyback'],
            ['weight'=>$data->weight + $existingWeight]
        );
    }
}
