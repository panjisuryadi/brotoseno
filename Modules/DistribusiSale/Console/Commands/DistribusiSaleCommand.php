<?php

namespace Modules\DistribusiSale\Console\Commands;

use Illuminate\Console\Command;

class DistribusiSaleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DistribusiSaleCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DistribusiSale Command description';

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
