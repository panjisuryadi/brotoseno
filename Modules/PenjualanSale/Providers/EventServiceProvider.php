<?php

namespace Modules\PenjualanSale\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\PenjualanSale\Events\PenjualanSaleDetailCreated' => [
            'Modules\PenjualanSale\Listeners\PenjualanSaleDetailCreated\UpdateStockSales',
        ],
    ];
}
