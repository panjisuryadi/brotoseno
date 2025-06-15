<?php

namespace Modules\ItemColour\Console\Commands;

use Illuminate\Console\Command;

class ItemColourCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ItemColourCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ItemColour Command description';

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
