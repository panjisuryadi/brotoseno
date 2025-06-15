<?php

namespace Modules\Timbangan\Console\Commands;

use Illuminate\Console\Command;

class TimbanganCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TimbanganCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Timbangan Command description';

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
