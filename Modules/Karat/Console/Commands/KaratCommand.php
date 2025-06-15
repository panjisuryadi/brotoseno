<?php

namespace Modules\Karat\Console\Commands;

use Illuminate\Console\Command;

class KaratCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KaratCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Karat Command description';

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
