<?php

namespace Modules\PenerimaanBarangLuar\Listeners\PenerimaanBarangLuarCreated;

use Modules\PenerimaanBarangLuar\Events\PenerimaanBarangLuarCreated;
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
     * @param PenerimaanBarangLuarCreated $event
     * @return void
     */
    public function handle(PenerimaanBarangLuarCreated $event)
    {
        $data = $event->penerimaanBarangLuar;

        $existingWeight = StockPending::where(
            [
                'karat_id' => $data->karat_id,
                'cabang_id' => $data->cabang_id,
                'type' => 'barangluar'
            ],
        )->value('weight');

        StockPending::updateOrCreate(
            ['cabang_id'=>$data->cabang_id,'karat_id'=>$data->karat_id,'type'=>'barangluar'],
            ['weight'=>$data->weight + $existingWeight]
        );
    }
}
