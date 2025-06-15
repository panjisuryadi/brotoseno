<?php

namespace Modules\DataSale\Console\Commands;

use Illuminate\Console\Command;

class DataSaleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DataSaleCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DataSale Command description';

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
