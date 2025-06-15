<?php

namespace Modules\CostParameter\Console\Commands;

use Illuminate\Console\Command;

class CostParameterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CostParameterCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CostParameter Command description';

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
