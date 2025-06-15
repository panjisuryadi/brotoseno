<?php

namespace Modules\GoodsReceipt\Listeners;

use Modules\GoodsReceipt\Events\GoodsReceiptItemCreated;
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
     * @param GoodsReceiptItemCreated $event
     * @return void
     */
    public function handle(GoodsReceiptItemCreated $event)
    {
        $goods_receipt = $event->goodsReceipt;
        $goods_receipt_item = $event->goodsReceiptItem;
        $stockOffice = StockOffice::where('karat_id', $goods_receipt_item->karat_id);
        $existingBeratBersih = $stockOffice->value('berat_real');
        $existingBeratKotor = $stockOffice->value('berat_kotor');
        StockOffice::updateOrCreate(
            ['karat_id' => $goods_receipt_item->karat_id],
            [
                'berat_real' => $goods_receipt_item->berat_real + $existingBeratBersih,
                'berat_kotor' => $goods_receipt_item->berat_kotor + $existingBeratKotor
            ]
        );
    }
}
