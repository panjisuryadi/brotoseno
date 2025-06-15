<?php

namespace Modules\DistribusiSale\Events;

use Illuminate\Queue\SerializesModels;
use Modules\DistribusiSale\Models\DistribusiSale;
use Modules\DistribusiSale\Models\DistribusiSaleDetail;

class DistribusiSaleDetailCreated
{
    use SerializesModels;

    public $dist_sale;
    public $dist_sale_detail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DistribusiSale $dist_sale,DistribusiSaleDetail $dist_sale_detail)
    {
        $this->dist_sale = $dist_sale;
        $this->dist_sale_detail = $dist_sale_detail;
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
