<?php

namespace Modules\StokCabang\Console\Commands;

use Illuminate\Console\Command;

class StokCabangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:StokCabangCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'StokCabang Command description';

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
