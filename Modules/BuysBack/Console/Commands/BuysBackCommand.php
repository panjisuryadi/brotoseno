<?php

namespace Modules\BuysBack\Console\Commands;

use Illuminate\Console\Command;

class BuysBackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:BuysBackCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BuysBack Command description';

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
