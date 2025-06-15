<?php

namespace Modules\DataEtalase\Console\Commands;

use Illuminate\Console\Command;

class DataEtalaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DataEtalaseCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DataEtalase Command description';

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
