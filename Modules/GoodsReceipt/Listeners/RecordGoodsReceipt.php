<?php

namespace Modules\GoodsReceipt\Listeners;

use Modules\GoodsReceipt\Events\GoodsReceiptItemCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\KeluarMasuk\Models\KeluarMasuk;
use Modules\Stok\Models\StockOffice;

class RecordGoodsReceipt implements ShouldQueue
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

        KeluarMasuk::create([
            'date' => $goods_receipt->date,
            'karat_id' => $goods_receipt_item->karat_id,
            'description' => "Penerimaan Barang dari " . $goods_receipt->pengirim,
            'weight_in' => $goods_receipt_item->berat_real,
            'remaining_weight' => StockOffice::where('karat_id',$goods_receipt_item->karat_id)->value('berat_real')
        ]);
    }
}
