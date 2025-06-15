<?php

namespace Modules\PenerimaanBarangLuarSale\Listeners\PenerimaanBarangLuarSaleCreated;

use Modules\PenerimaanBarangLuarSale\Events\PenerimaanBarangLuarSaleCreated;
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
     * @param PenerimaanBarangLuarSaleCreated $event
     * @return void
     */
    public function handle(PenerimaanBarangLuarSaleCreated $event)
    {
        $data = $event->penerimaanBarangLuarSale;
        $existingWeight = StockPending::where(
            [
                'sales_id' => $data->sales_id,
                'karat_id' => $data->karat_id,
                'type' => 'barangluar'
            ],
        )->value('weight');

        StockPending::updateOrCreate(
            ['sales_id' => $data->sales_id,'karat_id'=>$data->karat_id,'type'=>'barangluar'],
            ['weight'=>$data->weight + $existingWeight]
        );
    }
}
