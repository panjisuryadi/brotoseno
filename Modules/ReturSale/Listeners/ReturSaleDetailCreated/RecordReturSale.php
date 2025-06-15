<?php

namespace Modules\ReturSale\Listeners\ReturSaleDetailCreated;

use Modules\ReturSale\Events\ReturSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\KeluarMasuk\Models\KeluarMasuk;
use Modules\Stok\Models\StockOffice;

class RecordReturSale implements ShouldQueue
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

        KeluarMasuk::create([
            'date' => $retur_sale->date,
            'karat_id' => $retur_sale_detail->karat_id,
            'description' => "Retur Sales dari " . $retur_sale->sales->name,
            'weight_in' => $retur_sale_detail->weight,
            'remaining_weight' => StockOffice::where('karat_id',$retur_sale_detail->karat->parent->id)->value('berat_real')
        ]);
    }
}
