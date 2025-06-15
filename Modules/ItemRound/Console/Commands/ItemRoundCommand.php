<?php

namespace Modules\ItemRound\Console\Commands;

use Illuminate\Console\Command;

class ItemRoundCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ItemRoundCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ItemRound Command description';

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
