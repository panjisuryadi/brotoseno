<?php

namespace Modules\PenerimaanBarangLuarSale\Events;

use Illuminate\Queue\SerializesModels;
use Modules\PenerimaanBarangLuarSale\Models\PenerimaanBarangLuarSale;

class PenerimaanBarangLuarSaleCreated
{
    use SerializesModels;

    public $penerimaanBarangLuarSale;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PenerimaanBarangLuarSale $penerimaanBarangLuarSale)
    {
        $this->penerimaanBarangLuarSale = $penerimaanBarangLuarSale;
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
