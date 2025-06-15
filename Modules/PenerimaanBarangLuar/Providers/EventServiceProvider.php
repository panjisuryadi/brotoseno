<?php

namespace Modules\PenerimaanBarangLuar\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\PenerimaanBarangLuar\Events\PenerimaanBarangLuarCreated' => [
            'Modules\PenerimaanBarangLuar\Listeners\PenerimaanBarangLuarCreated\UpdateStockPending',
        ],
    ];
}
