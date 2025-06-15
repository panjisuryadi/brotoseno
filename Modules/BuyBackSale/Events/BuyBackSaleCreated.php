<?php

namespace Modules\BuyBackSale\Events;

use Illuminate\Queue\SerializesModels;
use Modules\BuyBackSale\Models\BuyBackSale;

class BuyBackSaleCreated
{
    use SerializesModels;

    public $buyBackSale;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BuyBackSale $buyBackSale)
    {
        $this->buyBackSale = $buyBackSale;
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
