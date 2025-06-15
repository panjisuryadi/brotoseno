<?php

namespace Modules\BuyBackSale\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\BuyBackSale\Events\BuyBackSaleCreated' => [
            'Modules\BuyBackSale\Listeners\BuyBackSaleCreated\UpdateStockPending',
        ],
    ];
}
