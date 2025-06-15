<?php

namespace Modules\PenjualanSale\Events;

use Illuminate\Queue\SerializesModels;
use Modules\PenjualanSale\Models\PenjualanSale;
use Modules\PenjualanSale\Models\PenjualanSaleDetail;
use Modules\PenjualanSale\Models\PenjualanSalesPayment;

class PenjualanSaleDetailCreated
{
    use SerializesModels;

    public $penjualan_sale;
    public $penjualan_sale_detail;

    public $penjualan_sale_payment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PenjualanSale $penjualanSale,PenjualanSaleDetail $penjualanSaleDetail, PenjualanSalesPayment $penjualanSalesPayment)
    {
        $this->penjualan_sale = $penjualanSale;
        $this->penjualan_sale_detail = $penjualanSaleDetail;
        $this->penjualan_sale_payment = $penjualanSalesPayment;
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
