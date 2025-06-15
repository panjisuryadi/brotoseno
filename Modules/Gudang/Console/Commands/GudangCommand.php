<?php

namespace Modules\Gudang\Console\Commands;

use Illuminate\Console\Command;

class GudangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GudangCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gudang Command description';

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
