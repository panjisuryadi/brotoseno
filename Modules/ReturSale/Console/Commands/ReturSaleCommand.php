<?php

namespace Modules\ReturSale\Console\Commands;

use Illuminate\Console\Command;

class ReturSaleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ReturSaleCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ReturSale Command description';

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
