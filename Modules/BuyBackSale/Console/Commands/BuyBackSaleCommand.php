<?php

namespace Modules\BuyBackSale\Console\Commands;

use Illuminate\Console\Command;

class BuyBackSaleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:BuyBackSaleCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BuyBackSale Command description';

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
