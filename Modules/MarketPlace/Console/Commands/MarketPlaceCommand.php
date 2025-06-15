<?php

namespace Modules\MarketPlace\Console\Commands;

use Illuminate\Console\Command;

class MarketPlaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MarketPlaceCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MarketPlace Command description';

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
