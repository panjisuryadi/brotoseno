<?php

namespace Modules\Cabang\Console\Commands;

use Illuminate\Console\Command;

class CabangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CabangCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cabang Command description';

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
