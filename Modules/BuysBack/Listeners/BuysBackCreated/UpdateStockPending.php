<?php

namespace Modules\BuysBack\Listeners\BuysBackCreated;

use Modules\BuysBack\Events\BuysBackCreated;
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
     * @param BuysBackCreated $event
     * @return void
     */
    public function handle(BuysBackCreated $event)
    {
        $newBuyBack = $event->buysBack;
        $existingWeight = StockPending::where(
            [
                'karat_id' => $newBuyBack->karat_id,
                'cabang_id' => $newBuyBack->cabang_id,
                'type' =>   'buyback'
            ],
        )->value('weight');

        StockPending::updateOrCreate(
            ['cabang_id'=>$newBuyBack->cabang_id,'karat_id'=>$newBuyBack->karat_id,'type'=>'buyback'],
            ['weight'=>$newBuyBack->weight + $existingWeight]
        );
    }
}
