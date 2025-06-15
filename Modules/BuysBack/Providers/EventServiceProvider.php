<?php

namespace Modules\BuysBack\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\BuysBack\Events\BuysBackCreated' => [
            'Modules\BuysBack\Listeners\BuysBackCreated\UpdateStockPending',
        ],
    ];
}
