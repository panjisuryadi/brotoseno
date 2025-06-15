<?php

namespace Modules\JenisBuyBack\Console\Commands;

use Illuminate\Console\Command;

class JenisBuyBackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:JenisBuyBackCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JenisBuyBack Command description';

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
