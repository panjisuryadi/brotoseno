<?php

namespace Modules\Group\Console\Commands;

use Illuminate\Console\Command;

class GroupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GroupCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Group Command description';

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
