<?php

namespace Modules\BuysBack\Events;

use Illuminate\Queue\SerializesModels;
use Modules\BuysBack\Models\BuysBack;
use Modules\Stok\Models\StockPending;

class BuysBackCreated
{
    use SerializesModels;

    public $buysBack;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BuysBack $buysBack)
    {
        $this->buysBack = $buysBack;
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
