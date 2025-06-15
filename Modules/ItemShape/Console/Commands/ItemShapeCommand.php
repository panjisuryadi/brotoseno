<?php

namespace Modules\ItemShape\Console\Commands;

use Illuminate\Console\Command;

class ItemShapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ItemShapeCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ItemShape Command description';

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
