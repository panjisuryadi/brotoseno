<?php

namespace Modules\GoodsReceiptBerlian\Console\Commands;

use Illuminate\Console\Command;

class GoodsReceiptBerlianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GoodsReceiptBerlianCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GoodsReceiptBerlian Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
