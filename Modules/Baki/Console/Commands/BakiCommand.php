<?php

namespace Modules\Baki\Console\Commands;

use Illuminate\Console\Command;

class BakiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:BakiCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Baki Command description';

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
