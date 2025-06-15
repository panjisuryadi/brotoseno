<?php

namespace Modules\Status\Console\Commands;

use Illuminate\Console\Command;

class StatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:StatusCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Status Command description';

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
