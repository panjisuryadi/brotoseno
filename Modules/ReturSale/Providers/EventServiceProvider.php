<?php

namespace Modules\ReturSale\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        'Modules\ReturSale\Events\ReturSaleDetailCreated' => [
            'Modules\ReturSale\Listeners\ReturSaleDetailCreated\UpdateStockSales',
            'Modules\ReturSale\Listeners\ReturSaleDetailCreated\UpdateStockOffice',
            'Modules\ReturSale\Listeners\ReturSaleDetailCreated\RecordReturSale'
        ],
    ];
}
