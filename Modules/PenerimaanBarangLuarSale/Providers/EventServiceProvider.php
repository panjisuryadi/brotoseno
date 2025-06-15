<?php

namespace Modules\PenerimaanBarangLuarSale\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\PenerimaanBarangLuarSale\Events\PenerimaanBarangLuarSaleCreated' => [
            'Modules\PenerimaanBarangLuarSale\Listeners\PenerimaanBarangLuarSaleCreated\UpdateStockPending',
        ],
    ];
}
