<?php

namespace Modules\ItemClarity\Console\Commands;

use Illuminate\Console\Command;

class ItemClarityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ItemClarityCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ItemClarity Command description';

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
