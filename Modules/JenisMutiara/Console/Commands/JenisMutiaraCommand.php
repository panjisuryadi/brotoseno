<?php

namespace Modules\JenisMutiara\Console\Commands;

use Illuminate\Console\Command;

class JenisMutiaraCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:JenisMutiaraCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JenisMutiara Command description';

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
