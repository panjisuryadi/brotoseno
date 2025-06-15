<?php

namespace Modules\DistribusiSale\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\DistribusiSale\Events\DistribusiSaleDetailCreated' => [
            'Modules\DistribusiSale\Listeners\DistribusiSaleDetailCreated\UpdateOrCreateStockSales',
            'Modules\DistribusiSale\Listeners\DistribusiSaleDetailCreated\UpdateStockOffice',
        ],
    ];
}
