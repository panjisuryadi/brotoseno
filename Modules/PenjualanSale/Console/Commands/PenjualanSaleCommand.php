<?php

namespace Modules\PenjualanSale\Console\Commands;

use Illuminate\Console\Command;

class PenjualanSaleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PenjualanSaleCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PenjualanSale Command description';

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
