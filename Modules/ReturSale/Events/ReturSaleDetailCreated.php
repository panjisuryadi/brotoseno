<?php

namespace Modules\ReturSale\Events;

use Illuminate\Queue\SerializesModels;
use Modules\ReturSale\Models\ReturSale;
use Modules\ReturSale\Models\ReturSaleDetail;

class ReturSaleDetailCreated
{
    use SerializesModels;

    public $retur_sale;
    public $retur_sale_detail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ReturSale $retur_sale,ReturSaleDetail $retur_sale_detail)
    {
        $this->retur_sale = $retur_sale;
        $this->retur_sale_detail = $retur_sale_detail;
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
