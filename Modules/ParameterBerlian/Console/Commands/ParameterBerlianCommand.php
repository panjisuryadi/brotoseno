<?php

namespace Modules\ParameterBerlian\Console\Commands;

use Illuminate\Console\Command;

class ParameterBerlianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ParameterBerlianCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ParameterBerlian Command description';

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
