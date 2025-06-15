<?php

namespace Modules\GoodsReceipt\Events;

use Illuminate\Queue\SerializesModels;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;

class GoodsReceiptItemCreated
{
    use SerializesModels;

    public $goodsReceipt;
    public $goodsReceiptItem;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(GoodsReceipt $goodsReceipt, GoodsReceiptItem $goodsReceiptItem)
    {
        $this->goodsReceipt = $goodsReceipt;
        $this->goodsReceiptItem = $goodsReceiptItem;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
