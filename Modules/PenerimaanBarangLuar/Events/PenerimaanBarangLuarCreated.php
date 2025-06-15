<?php

namespace Modules\PenerimaanBarangLuar\Events;

use Illuminate\Queue\SerializesModels;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;

class PenerimaanBarangLuarCreated
{
    use SerializesModels;

    public $penerimaanBarangLuar;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PenerimaanBarangLuar $penerimaanBarangLuar)
    {
        $this->penerimaanBarangLuar = $penerimaanBarangLuar;
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
