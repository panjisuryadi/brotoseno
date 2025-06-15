<?php

namespace Modules\DistribusiToko\Console\Commands;

use Illuminate\Console\Command;

class DistribusiTokoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DistribusiTokoCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DistribusiToko Command description';

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
