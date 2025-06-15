<?php

namespace Modules\Stok\Console\Commands;

use Illuminate\Console\Command;

class StokCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:StokCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stok Command description';

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
