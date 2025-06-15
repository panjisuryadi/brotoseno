<?php

namespace Modules\StoreEmployee\Console\Commands;

use Illuminate\Console\Command;

class StoreEmployeeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:StoreEmployeeCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'StoreEmployee Command description';

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
