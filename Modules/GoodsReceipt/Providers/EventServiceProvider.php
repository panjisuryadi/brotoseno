<?php

namespace Modules\GoodsReceipt\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Modules\GoodsReceipt\Events\GoodsReceiptItemCreated' => [
            'Modules\GoodsReceipt\Listeners\UpdateStockOffice',
            'Modules\GoodsReceipt\Listeners\RecordGoodsReceipt'
        ],
    ];
}
